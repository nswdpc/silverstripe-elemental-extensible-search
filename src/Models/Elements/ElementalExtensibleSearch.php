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
 * ElementalExtensibleSearch adds an search field
 */
class ElementalExtensibleSearch extends BaseElement
{
    private static $icon = "font-icon-search";

    private static $table_name = "ElementalExtensibleSearch";

    private static $title = "Search";
    private static $description = "Display an search block";

    private static $singular_name = "Search";
    private static $plural_name = "Searches";

    private static $inline_editable = false;

    public function getType()
    {
        return _t(__CLASS__ . ".BlockType", "Search");
    }

    private static $db = [
        'Subtitle' => 'Varchar(255)',
        'ShowTerms' => 'Boolean'
    ];

    private static $has_one = [
        'Image' => Image::class,
        'SearchPage' => ExtensibleSearchPage::class
    ];

    private static $many_many = [
        'SearchLinks' => Link::class
    ];

    private static $many_many_extraFields = [
        'SearchLinks' => ['SortOrder' => 'Int']

    ];
    private static $owns = ['Image'];

    public function getAllowedFileTypes()
    {
        $types = $this->config()->get("allowed_file_types");
        if (empty($types)) {
            $types = ["jpg", "jpeg", "gif", "png", "webp"];
        }
        $types = array_unique($types);
        return $types;
    }

    public function getFolderName() {
        $folder_name = $this->config()->get('folder_name');
        if(!$folder_name) {
            $folder_name = "images";
        }
        return $folder_name;
    }

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

    public function getElementSearchForm($request = null, $sorting = false) {
        return ($page = $this->getSearchPage()) ? ModelAsController::controller_for($page)->getSearchForm($request, $sorting) : null;
    }

    public function getSearchPage() {
        $page = $this->SearchPage();
        return $page;
    }

}

