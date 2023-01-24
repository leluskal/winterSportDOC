<?php
declare(strict_types=1);

namespace App\Presenters;

use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;
use Nette\Utils\ArrayHash;
use Nette\Utils\DateTime;

abstract class BasePresenter extends Presenter
{
    /**
     * @persistent
     */
    public $year;

    public function beforeRender()
    {
        parent::beforeRender();

        if ($this->year === null) {
            $this->year = DateTime::from('now')->format('Y');
        }
    }

    public function createComponentYearForm(): Form
    {
        $form = new Form();

        $form->addSelect('year', 'Year', [2022 => 2022, 2023 => 2023]);

        $form->addSubmit('save', 'Save');

        $form->onSuccess[] = [$this, 'yearFormSuccess'];

        return $form;
    }

    public function yearFormSuccess(Form $form, ArrayHash $values)
    {
        $this->year = $values->year;

        $this->flashMessage('The year has been set', 'success');
        $this->redirect('this');
    }
}