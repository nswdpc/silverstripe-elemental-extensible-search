<?php

namespace NSWDPC\Elemental\Models\ExtensibleSearch;

use DNADesign\Elemental\Models\BaseElement;
use gorriecoe\Link\Models\Link;
use gorriecoe\LinkField\LinkField;
use nglasl\extensible\ExtensibleSearchPage;
use Silverstripe\Forms\CheckboxField;
use Silverstripe\Forms\TextField;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;

/**
 * ElementalExtensibleSearch provides a content block with a search field,
 * linked to an {@link nglasl\extensible\ExtensibleSearchPage}
 *
 * This search element can be decorated with links, optional terms and images
 *
 * Using an extensible search page as configuration
 *
 * @author Mark
 * @author James
 */
class ElementalExtensibleSearch extends BaseElement
{

    use SearchElement;

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
        return _t(
            __CLASS__ . ".BlockType",
            "Search"
        );
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
        'SearchLinks' => [
            'SortOrder' => 'Int'
        ]
    ];

    /**
     * @inheritdoc
     */
    private static $owns = [
        'Image'
    ];


    /**
     * @inheritdoc
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName(['SearchLinks']);
        $fields->addFieldsToTab(
            "Root.Main",
            [

                TextField::create(
                    "Subtitle",
                    _t(
                        __CLASS__ . ".SUBTITLE",
                    "Subtitle"
                    )
                ),

                UploadField::create(
                    "Image",
                    _t(
                        __CLASS__ . ".SLIDE_IMAGE",
                       "Image"
                    )
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
                    _t(
                        __CLASS__ . ".SHOW_SEARCH_TERMS",
                       "Show search terms"
                    )
                )->setDescription(
                    _t(
                        __CLASS__ . ".SHOW_SEARCH_TERMS_DESCRIPTION",
                        'Show approved search terms below the search field (adding search links below will override this)'
                    )
                ),

                LinkField::create(
                    "SearchLinks",
                    _t(
                        __CLASS__ . ".SEARCHLINKS",
                       "Search links"
                    ),
                    $this->owner
                )->setSortColumn('SortOrder')
            ]
        );
        return $fields;
    }

}
