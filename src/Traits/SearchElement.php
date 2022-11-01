<?php

namespace NSWDPC\Elemental\Models\ExtensibleSearch;


use nglasl\extensible\ExtensibleSearchPage;
use SilverStripe\CMS\Controllers\ModelAsController;
use SilverStripe\CMS\Search\SearchForm;

/**
 * Reusable methods across extensible search elements
 *
 * @author James
 */
trait SearchElement {

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
    public function getFolderName() : string
    {
        $folder_name = $this->config()->get('folder_name');
        if (!$folder_name) {
            $folder_name = "images";
        }
        return $folder_name;
    }


    /**
     * Return search form (or not)
     */
    public function getElementSearchForm($request = null, $sorting = false) : ?SearchForm
    {
        $page = $this->getSearchPage();
        if (!$page) {
            return null;
        }
        $searchForm = ModelAsController::controller_for($page)->getSearchForm($request, $sorting);
        if (!($searchForm instanceof SearchForm)) {
            return null;
        } else {
            return $searchForm;
        }
    }

    /**
     * Return search page, if set
     */
    public function getSearchPage() : ?ExtensibleSearchPage
    {
        $page = $this->SearchPage();
        return $page && $page->exists() ? $page : null;
    }

}
