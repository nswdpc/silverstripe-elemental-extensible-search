<?php

namespace NSWDPC\Elemental\Models\ExtensibleSearch\Tests;

use gorriecoe\Link\Models\Link;
use gorriecoe\LinkField\LinkField;
use nglasl\extensible\ExtensibleSearchPage;
use NSWDPC\Elemental\Models\ExtensibleSearch\ElementalExtensibleSearch;
use SilverStripe\Control\Controller;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\ORM\FieldType\DBDatetime;
use SilverStripe\CMS\Search\SearchForm;
use SilverStripe\View\SSViewer;

//require_once(dirname(__FILE__) . '/TestCustomSearchEngine.php');

/**
 * Unit test to verify field handling in element
 * @author James
 */
class ElementalExtensibleSearchTest extends SapphireTest
{

    /**
     * @inheritdoc
     */
    protected $usesDatabase = true;

    /**
     * @inheritdoc
     */
    protected static $fixture_file = './ElementalExtensibleSearchTest.yml';

    protected function setUp() : void
    {
        parent::setUp();
        SSViewer::set_themes(['$public', '$default']);
    }

    public function testTemplate()
    {
        $element = $this->objFromFixture(ElementalExtensibleSearch::class, 'elementwithsearchpage');
        $element->doPublish();

        $template = $element->forTemplate()->RAW();

        // simple way of test we get a form with a button from our basic template
        $this->assertNotFalse(strpos($template, "action_getSearchResults"));
        $this->assertNotFalse(strpos($template, "<form "));
    }

    /**
     * Test search page method return
     */
    public function testSearchPage()
    {
        $element = $this->objFromFixture(ElementalExtensibleSearch::class, 'elementwithsearchpage');
        $element->doPublish();

        $expectedSearchPage = $this->objFromFixture(ExtensibleSearchPage::class, 'searchpage');
        $expectedSearchPage->doPublish();

        $searchPage = $element->getSearchPage();

        $this->assertNotNull($searchPage);
        $this->assertNotNull($expectedSearchPage);
        $this->assertEquals($expectedSearchPage->ID, $searchPage->ID);
    }

    /**
     * Test search page return when element has no search page
     */
    public function testSearchNoPage()
    {
        $element = $this->objFromFixture(ElementalExtensibleSearch::class, 'elementwithnosearchpage');
        $element->doPublish();

        $searchPage = $element->getSearchPage();

        $this->assertNull($searchPage);
    }


    /**
     * Test search page method return
     */
    public function testSearchForm()
    {
        $element = $this->objFromFixture(ElementalExtensibleSearch::class, 'elementwithsearchpage');
        $element->doPublish();

        $expectedSearchPage = $this->objFromFixture(ExtensibleSearchPage::class, 'searchpage');
        $expectedSearchPage->doPublish();

        $controller = Controller::curr();
        $searchForm = $element->getElementSearchForm($controller->getRequest());

        $this->assertNotNull($searchForm);
    }

    /**
     * Test search page return when element has no search page
     */
    public function testSearchNoForm()
    {
        $element = $this->objFromFixture(ElementalExtensibleSearch::class, 'elementwithnosearchpage');
        $element->doPublish();

        $searchForm = $element->getElementSearchForm();

        $this->assertNull($searchForm);
    }
}
