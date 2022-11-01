<?php

namespace NSWDPC\Elemental\Models\ExtensibleSearch;

use DNADesign\Elemental\Models\BaseElement;
use nglasl\extensible\ExtensibleSearchPage;

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
    private static $description = "Display a search block";

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
    private static $has_one = [
        'SearchPage' => ExtensibleSearchPage::class
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
