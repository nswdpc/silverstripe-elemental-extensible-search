<?php
namespace NSWDPC\Elemental\Models\ExtensibleSearch\Tests;

use nglasl\extensible\CustomSearchEngine;
use SilverStripe\Dev\TestOnly;

/**
 * Test search engine class, does nothing
 */
class TestCustomSearchEngine extends CustomSearchEngine implements TestOnly {

    public function getSelectableFields($page = null) {
        return [];
    }

	public function getSearchResults($data = null, $form = null, $page = null) {
        return [];
    }
}
