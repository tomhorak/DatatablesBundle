<?php

/**
 * This file is part of the SgDatatablesBundle package.
 *
 * (c) stwe <https://github.com/stwe/DatatablesBundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sg\DatatablesBundle\Datatable\View;

use Sg\DatatablesBundle\Column\ColumnBuilder;

use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\Translator;

/**
 * Class AbstractDatatableView
 *
 * @package Sg\DatatablesBundle\Datatable\View
 */
abstract class AbstractDatatableView implements DatatableViewInterface
{
    /**
     * The Templating service.
     *
     * @var TwigEngine
     */
    private $templating;

    /**
     * The Translator service.
     *
     * @var Translator
     */
    private $translator;

    /**
     * The Router service.
     *
     * @var RouterInterface
     */
    private $router;

    /**
     * A Features instance.
     *
     * @var Features
     */
    private $features;

    /**
     * A Options instance.
     *
     * @var Options
     */
    private $options;

    /**
     * A Multiselect instance.
     *
     * @var Multiselect
     */
    private $multiselect;

    /**
     * A ColumnBuilder instance.
     *
     * @var ColumnBuilder
     */
    private $columnBuilder;

    /**
     * A Ajax instance.
     *
     * @var Ajax
     */
    private $ajax;

    // Columns

    // Internationalisation

    /**
     * Enable or disable individual filtering.
     *
     * @var boolean
     */
    private $individualFiltering;

    /**
     * The name of the Twig template.
     *
     * @var string
     */
    private $template;


    //-------------------------------------------------
    // Ctor.
    //-------------------------------------------------

    /**
     * Ctor.
     *
     * @param TwigEngine      $templating           The templating service
     * @param Translator      $translator           The translator service
     * @param RouterInterface $router               The router service
     * @param array           $defaultLayoutOptions The default layout options
     */
    public function __construct(TwigEngine $templating, Translator $translator, RouterInterface $router, array $defaultLayoutOptions)
    {
        $this->templating = $templating;
        $this->translator = $translator;
        $this->router = $router;

        $this->features = new Features();
        $this->features->setServerSide($defaultLayoutOptions["server_side"]);
        $this->features->setProcessing($defaultLayoutOptions["processing"]);

        $this->options = new Options();
        $this->options->setPageLength($defaultLayoutOptions["page_length"]);

        $this->multiselect = new Multiselect($defaultLayoutOptions["multiselect"]);
        $this->columnBuilder = new ColumnBuilder();
        $this->ajax = new Ajax();

        $this->individualFiltering = $defaultLayoutOptions["individual_filtering"];
        $this->template = "SgDatatablesBundle:Datatable:datatable.html.twig";
    }


    //-------------------------------------------------
    // DatatableViewInterface
    //-------------------------------------------------

    /**
     * {@inheritdoc}
     */
    abstract public function buildDatatableView();

    /**
     * {@inheritdoc}
     */
    public function renderDatatableView()
    {
        $options = array();

        $options['view_features'] = $this->features;
        $options['view_options'] = $this->options;
        $options['view_multiselect'] = $this->multiselect;
        $options['view_columns'] = $this->columnBuilder->getColumns();
        $options['view_ajax'] = $this->ajax;

        $options['view_individual_filtering'] = $this->individualFiltering;
        $options['view_table_id'] = $this->getName();

        return $this->templating->render($this->template, $options);
    }

    /**
     * {@inheritdoc}
     */
    abstract public function getName();


    //-------------------------------------------------
    // Getters && Setters
    //-------------------------------------------------

    /**
     * Set Ajax.
     *
     * @param Ajax $ajax
     *
     * @return $this
     */
    public function setAjax($ajax)
    {
        $this->ajax = $ajax;

        return $this;
    }

    /**
     * Get Ajax.
     *
     * @return Ajax
     */
    public function getAjax()
    {
        return $this->ajax;
    }

    /**
     * Set ColumnBuilder.
     *
     * @param ColumnBuilder $columnBuilder
     *
     * @return $this
     */
    public function setColumnBuilder($columnBuilder)
    {
        $this->columnBuilder = $columnBuilder;

        return $this;
    }

    /**
     * Get ColumnBuilder.
     *
     * @return ColumnBuilder
     */
    public function getColumnBuilder()
    {
        return $this->columnBuilder;
    }

    /**
     * Set Features.
     *
     * @param Features $features
     *
     * @return $this
     */
    public function setFeatures($features)
    {
        $this->features = $features;

        return $this;
    }

    /**
     * Get Features.
     *
     * @return Features
     */
    public function getFeatures()
    {
        return $this->features;
    }

    /**
     * Set IndividualFiltering.
     *
     * @param boolean $individualFiltering
     *
     * @return $this
     */
    public function setIndividualFiltering($individualFiltering)
    {
        $this->individualFiltering = $individualFiltering;

        return $this;
    }

    /**
     * Get IndividualFiltering.
     *
     * @return boolean
     */
    public function getIndividualFiltering()
    {
        return $this->individualFiltering;
    }

    /**
     * Set Multiselect.
     *
     * @param Multiselect $multiselect
     *
     * @return $this
     */
    public function setMultiselect($multiselect)
    {
        $this->multiselect = $multiselect;

        return $this;
    }

    /**
     * Get Multiselect.
     *
     * @return Multiselect
     */
    public function getMultiselect()
    {
        return $this->multiselect;
    }

    /**
     * Set Options.
     *
     * @param Options $options
     *
     * @return $this
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Get Options.
     *
     * @return Options
     */
    public function getOptions()
    {
        return $this->options;
    }
}

