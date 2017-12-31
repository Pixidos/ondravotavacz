<?php
/**
 * Created by PhpStorm.
 * User: ondra
 * Date: 28.12.17
 * Time: 9:18
 */

namespace App\Service;


use App\Exceptions\LogicException;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;

class ContactForm
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;
    /**
     * @var SendMail
     */
    private $sendMail;
    
    /**
     * @var FormInterface
     */
    private $form;
    
    /**
     * ContactForm constructor.
     *
     * @param FormFactoryInterface $formFactory
     * @param SendMail             $sendMail
     */
    public function __construct(FormFactoryInterface $formFactory, SendMail $sendMail)
    {
        $this->formFactory = $formFactory;
        $this->sendMail = $sendMail;
    }
    
    /**
     * @return FormView
     * @throws \App\Exceptions\LogicException
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    public function getFromView(): FormView
    {
        if (null === $this->form) {
            throw new LogicException(sprintf('Must call method %s::create() before', static::class));
        }
    
        return $this->form->createView();
    }
    
    /**
     * @param Request $request
     *
     * @return bool
     * @throws \Symfony\Component\Form\Exception\LogicException
     * @throws \App\Exceptions\LogicException
     */
    public function handleRequest(Request $request): bool
    {
        if (null === $this->form) {
            throw new LogicException(sprintf('Must call method %s::create() before', static::class));
        }
        
        if (!$request->isMethod('POST')) {
            return false;
        }
        // for reset data
        $clone = clone $this->form;
        $this->form->handleRequest($request);
        if (!$this->form->isValid()) {
            return false;
        }
        
        $data = $this->form->getData();
        if ($this->sendMail->send($data['email'], $data['subject'], $data['message'])) {
            $this->form = $clone;
            return true;
        }
        $this->form->addError(new FormError('failed email send'));
        return false;
    }
    
    /**
     * @param string $action
     *
     * @return FormInterface
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    public function create(string $action): FormInterface
    {
        return $this->form = $this->formFactory->create(
            \App\Forms\ContactForm::class, null, [
                'action' => $action,
            ]
        );
    }
    
    
    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->getErrorsFromForm($this->form);
    }
    
    /**
     * @param FormInterface $form
     *
     * @return array
     */
    private function getErrorsFromForm(FormInterface $form): array
    {
        $errors = array();
        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }
        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface) {
                if ($childErrors = $this->getErrorsFromForm($childForm)) {
                    $errors[$childForm->getName()] = $childErrors;
                }
            }
        }
        return $errors;
    }
}
