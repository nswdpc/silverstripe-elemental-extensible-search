<?php
namespace NSWDPC\Elemental\Models\ExtensibleSearch;

use DNADesign\Elemental\Models\BaseElement;
use nglasl\extensible\ExtensibleSearchPage;
use SilverStripe\CMS\Controllers\ModelAsController;
use gorriecoe\Link\Models\Link;
use gorriecoe\LinkField\LinkField;
use Silverstripe\Forms\CheckboxField;
use Silverstripe\Forms\TextField;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;

/**
 * ElementalExtensibleSearch provides a content block with a search field
 * Using an extensible search page as configuration
 *
 * @author Mark
 * @author James
 */
class ElementalExtensibleSearch extends BaseElement
{

    /**
     * @inheritdoc
     */
    private static $icon = "font-icon-search";

    /**
     * @inheritdoc
     */
    private static $table_name = "ElementalExtensibleSearch";

    /**
     * @inheritdoc
     */
    private static $title = "Search";

    /**
     * @inheritdoc
     */
    private static $description = "Display an search block";

    /**
     * @inheritdoc
     */
    private static $singular_name = "Search";

    /**
     * @inheritdoc
     */
    private static $plural_name = "Searches";

    /**
     * @inheritdoc
     */
    private static $inline_editable = false;

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return _t(__CLASS__ . ".BlockType", "Search");
    }

    /**
     * @inheritdoc
     */
    private static $db = [
        'Subtitle' => 'Varchar(255)',
        'ShowTerms' => 'Boolean'
    ];

    /**
     * @inheritdoc
     */
    private static $has_one = [
        'Image' => Image::class,
        'SearchPage' => ExtensibleSearchPage::class
    ];

    /**
     * @inheritdoc
     */
    private static $many_many = [
        'SearchLinks' => Link::class
    ];

    /**
     * @inheritdoc
     */
    private static $many_many_extraFields = [
        'SearchLinks' => ['SortOrder' => 'Int']

    ];

    /**
     * @inheritdoc
     */
    private static $owns = ['Image'];

    /**
     * Allowed file types for image relation
     */
    public function getAllowedFileTypes() : array
    {
        $types = $this->config()->get("allowed_file_types");
        if (empty($types)) {
            $types = ["jpg", "jpeg", "gif", "png", "webp"];
        }
        $types = array_unique($types);
        return $types;
    }

    /**
     * Folder to store images
     */
    public function getFolderName() : string {
        $folder_name = $this->config()->get('folder_name');
        if(!$folder_name) {
            $folder_name = "images";
        }
        return $folder_name;
    }

    /**
     * @inheritdoc
     */
    public function getCMSFields()
    {

        $this->beforeUpdateCMSFields(function ($fields) {
            $fields->removeByName(['SearchLinks']);
            $fields->addFieldsToTab("Root.Main", [
                TextField::create(
                    "Subtitle",
                    _t(__CLASS__ . ".SUBTITLE", "Subtitle")
                ),
                UploadField::create(
                    "Image",
                    _t(__CLASS__ . ".SLIDE_IMAGE", "Image")
                )
                ->setFolderName($this->getFolderName() . "/" . $this->ID)
                ->setAllowedExtensions($this->getAllowedFileTypes())
                ->setIsMultiUpload(false)
                ->setDescription(
                    _t(
                        __CLASS__ . "ALLOWED_FILE_TYPES",
                        "Allowed file types: {types}",
                        [
                            'types' => implode(",", $this->getAllowedFileTypes())
                        ]
                    )
                ),
                CheckboxField::create(
                    "ShowTerms",
                    _t(__CLASS__ . ".SUBTITLE", "Show search terms")
                )->setDescription('Show approved search terms below the search field (adding search links below will override this)'),
                LinkField::create(
                    "SearchLinks",
                    _t(__CLASS__ . ".SEARCHLINKS", "Search links"),
                    $this->owner
                )->setSortColumn('SortOrder')
            ]);
        });
        return parent::getCMSFields();
    }

    /**
     * Return search form (or not)
     */
    public function getElementSearchForm($request = null, $sorting = false) : ?Form {
        return ($page = $this->getSearchPage()) ? ModelAsController::controller_for($page)->getSearchForm($request, $sorting) : null;
    }

    /**
     * Return search page, if set
     */
    public function getSearchPage() : ?ExtensibleSearchPage {
        $page = $this->SearchPage();
        return $page;
    }

}

