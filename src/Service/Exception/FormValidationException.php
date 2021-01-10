<?php

declare(strict_types=1);

namespace App\Service\Exception;

use Symfony\Component\Form\FormInterface;

/**
 * @author Karol Gancarczyk
 */
class FormValidationException extends InvalidArgumentException
{
    private FormInterface $form;

    public function __construct(FormInterface $form)
    {
        parent::__construct('Invalid data passed to form');
        $this->form = $form;
    }

    public function getErrors(): array
    {
        return $this->getErrorsFromForm($this->form);
    }

    private function getErrorsFromForm(FormInterface $form, int $level = 0): array
    {
        $errors = [];

        if ($level === 0) {
            foreach ($form->getErrors(true) as $error) {
                if (!isset($errors['form'])) {
                    $errors['form'] = [];
                }
                $errors['form'][$error->getOrigin()->getName()] = $error->getMessage();
            }
        } else {
            foreach ($form->getErrors(true) as $error) {
                $errors[$error->getOrigin()->getName()] = $error->getMessage();
            }
        }

        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface) {
                if ($childErrors = $this->getErrorsFromForm($childForm, $level + 1)) {
                    $errors[$childForm->getName()] = $childErrors;
                }
            }
        }

        return $errors;
    }
}
