<?php

declare(strict_types=1);

namespace WapplerSystems\Pricing\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use WapplerSystems\Pricing\Domain\Repository\TableRepository;
use WapplerSystems\Pricing\View\TablePresenter;

class TableController extends ActionController
{
    public function __construct(
        private readonly TableRepository $tableRepository,
        private readonly TablePresenter $presenter,
    ) {}

    public function showAction(): ResponseInterface
    {
        $uid = (int)($this->settings['table'] ?? 0);
        $tabelle = $uid > 0 ? $this->tableRepository->findByUid($uid) : null;

        if ($tabelle === null) {
            $this->view->assign('fehlt', true);
            return $this->htmlResponse();
        }

        $this->view->assignMultiple($this->presenter->bereite($tabelle));
        $this->view->assign('darstellung', $this->settings['layout'] ?? 'cards');
        $this->view->assign('matrixAnzeigen', (bool)($this->settings['showMatrix'] ?? false));
        $this->view->assign('matrixEingeklappt', (bool)($this->settings['collapseMatrix'] ?? false));

        return $this->htmlResponse();
    }
}
