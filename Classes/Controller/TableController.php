<?php

declare(strict_types=1);

namespace WapplerSystems\Pricing\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Site\Entity\SiteLanguage;
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
        $table = $uid > 0 ? $this->tableRepository->findByUid($uid) : null;

        if ($table === null) {
            $this->view->assign('missing', true);
            return $this->htmlResponse();
        }

        $siteLanguage = $this->request->getAttribute('language');
        $this->view->assignMultiple($this->presenter->prepare(
            $table,
            $siteLanguage instanceof SiteLanguage ? $siteLanguage : null,
        ));
        $this->view->assign('layout', $this->settings['layout'] ?? 'cards');
        $this->view->assign('showMatrix', (bool)($this->settings['showMatrix'] ?? false));
        $this->view->assign('collapseMatrix', (bool)($this->settings['collapseMatrix'] ?? false));

        return $this->htmlResponse();
    }
}
