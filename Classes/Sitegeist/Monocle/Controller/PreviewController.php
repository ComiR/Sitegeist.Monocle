<?php

namespace Sitegeist\Monocle\Controller;

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Utility\Arrays;
use TYPO3\Flow\Mvc\Controller\ActionController;
use TYPO3\TYPO3CR\Domain\Model\NodeInterface;

use Sitegeist\Monocle\Helper\TypoScriptHelper;
use Sitegeist\Monocle\Helper\ContextHelper;
use Sitegeist\Monocle\TypoScript\TypoScriptService;

class PreviewController extends ActionController
{

    /**
     * @var array
     * @Flow\InjectConfiguration("preview.defaultPath")
     */
    protected $defaultPath;

    /**
     * @var array
     * @Flow\InjectConfiguration("preview.additionalResources")
     */
    protected $additionalResources;

    /**
     * @Flow\Inject
     * @var TypoScriptService
     */
    protected $typoScriptService;

    /**
     * @Flow\Inject
     * @var TypoScriptHelper
     */
    protected $typoScriptHelper;

    /**
     * @Flow\Inject
     * @var ContextHelper
     */
    protected $contextHelper;

    /**
     * @param string $path
     * @param boolean $showRenderedResult
     * @param boolean $showRenderedCode
     * @param boolean $showDescription
     * @return void
     */
    public function showPathAction($path, $showRenderedResult = TRUE, $showRenderedCode = FALSE, $showDescription = FALSE) {
        $context = $this->contextHelper->getContext();
        $siteNode = $context->getCurrentSiteNode();

        $typoScriptObjectTree = $this->typoScriptService->getMergedTypoScriptObjectTree($siteNode);
        $styleguideObjectTree = $this->typoScriptHelper->buildStyleguideObjectTree($typoScriptObjectTree);

        $this->view->assign('path', $path);
        $this->view->assign('node',  $siteNode);

        $this->view->assign('styleguideObjectTree', Arrays::getValueByPath($styleguideObjectTree, $path));
        $this->view->assign('showRenderedResult', $showRenderedResult);
        $this->view->assign('showRenderedCode', $showRenderedCode);
        $this->view->assign('showDescription', $showDescription);

        $this->view->assign('additionalResources', $this->additionalResources);
    }

    /**
     * @param string $prototypeName
     * @param boolean $showRenderedResult
     * @param boolean $showRenderedCode
     * @param boolean $showDescription
     * @return void
     */
    public function showPrototypeAction($prototypeName, $showRenderedResult = TRUE, $showRenderedCode = FALSE, $showDescription = FALSE) {

        $context = $this->contextHelper->getContext();
        $siteNode = $context->getCurrentSiteNode();

        $this->view->assign('prototypeName', $prototypeName);
        $this->view->assign('node',  $siteNode);

        $this->view->assign('showRenderedResult', $showRenderedResult);
        $this->view->assign('showRenderedCode', $showRenderedCode);
        $this->view->assign('showDescription', $showDescription);

        $this->view->assign('additionalResources', $this->additionalResources);
    }
}