<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\Gender;

use App\Model\Entities\Gender\Gender;
use App\Model\Repositories\GenderRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\SmartObject;
use Nette\Utils\ArrayHash;

class GenderForm extends Control
{
    use SmartObject;

    public array $onFinish;

    private GenderRepository $genderRepository;

    public function __construct(GenderRepository $genderRepository)
    {
        $this->genderRepository = $genderRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addText('name', 'Gender');

        $form->addSubmit('save', 'Save');

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        if ($values->id === '') {
            $gender = new Gender(
                $values->name
            );

            $this->genderRepository->save($gender);
            $this->getPresenter()->flashMessage('The new gender record is saved', 'success');
        }

        if ($values->id !== '') {
            $gender = $this->genderRepository->getById((int) $values->id);

            $gender->setName($values->name);

            $this->genderRepository->save($gender);
            $this->getPresenter()->flashMessage('The gender record is updated', 'info');
        }

        $this->onFinish($this);
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/genderForm.latte');
        $template->render();
    }
}