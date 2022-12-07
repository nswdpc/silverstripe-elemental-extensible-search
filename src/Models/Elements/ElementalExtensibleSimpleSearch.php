<?php

namespace NSWDPC\Elemental\Models\ExtensibleSearch;

use DNADesign\Elemental\Models\BaseElement;
use nglasl\extensible\ExtensibleSearchPage;
use SilverStripe\Assets\Image;

/**
 * Simple search element, from which other search elements can be based,
 * linked to an {@link nglasl\extensible\ExtensibleSearchPage}
 *
 * Using an extensible search page as configuration
 *
 * @author Mark
 * @author James
 */
class ElementalExtensibleSimpleSearch extends BaseElement
{

    use SearchElement;

    /**
     * @inheritdoc
     */
    private static $icon = "font-icon-search";

    /**
     * @inheritdoc
     */
    private static $table_name = "ElementalExtensibleSimpleSearch";

    /**
     * @inheritdoc
     */
    private static $title = "Search";

    /**
     * @inheritdoc
     */
    private static $description = "Display a search field that can be decorated with optional content";

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
    private static $inline_editable = true;

    /**
     * @inheritdoc
     */
    private static $db = [
        'Content' => 'Text',
        'FieldTitle' => 'Varchar(255)'
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
    private static $owns = [
        'Image'
    ];

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return _t(
            __CLASS__ . ".BlockType",
            "Simple search"
        );
    }

}
