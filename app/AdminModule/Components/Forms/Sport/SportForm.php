<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\Sport;

use App\Model\Entities\Sport\Sport;
use App\Model\Repositories\SportRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\SmartObject;
use Nette\Utils\ArrayHash;

class SportForm extends Control
{
    use SmartObject;

    public array $onFinish;

    public array $onDelete;

    private SportRepository $sportRepository;

    public function __construct(SportRepository $sportRepository)
    {
        $this->sportRepository = $sportRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addText('name', 'Sport')
             ->setRequired('The name is required');

        $form->addSubmit('save', 'Save');

        $form->addSubmit('delete', 'Delete')
             ->setValidationScope([$form['id']]);

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        if ($form['delete']->isSubmittedBy()) {
            $sport = $this->sportRepository->getById((int) $values->id);
            $this->sportRepository->delete($sport);
            $this->getPresenter()->flashMessage('The sport record is deleted', 'info');
            $this->onDelete($this);
        }

        if ($values->id === '') {
            $sport = new Sport(
                $values->name
            );

            $this->sportRepository->save($sport);
            $this->getPresenter()->flashMessage('The new sport record is saved', 'success');
        }

        if ($values->id !== '') {
            $sport = $this->sportRepository->getById((int) $values->id);

            $sport->setName($values->name);

            $this->sportRepository->save($sport);
            $this->getPresenter()->flashMessage('The sport record is updated', 'info');
        }

        $this->onFinish($this);
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/sportForm.latte');
        $template->render();
    }
}