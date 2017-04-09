<?php

namespace App\Components;

class Pagination
{

    /**
     *
     * @var Navigation links to the page
     *
     */
    private $max = 10;

    /**
     *
     * @var The key to GET in which is written the page number
     *
     */
    private $index = 'page';

    /**
     *
     * @var Current page
     *
     */
    private $current_page;

    /**
     *
     * @var The total number of records
     *
     */
    private $total;

    /**
     *
     * @var Records per page
     *
     */
    private $limit;

    /**
     * Run the required data for navigation
     * @param type $total <p>The total number of records</p>
     * @param type $currentPage <p>The current page number</p>
     * @param type $limit <p>The number of records per page</p>
     * @param type $index <p>The key for the url</p>
     */
    public function __construct($total, $currentPage, $limit, $index)
    {
        # Set total number of records
        $this->total = $total;

        # Set the number of records per page
        $this->limit = $limit;

        # Set the token in the url
        $this->index = $index;

        # Set the number of pages
        $this->amount = $this->amount();

        # Set the current page number
        $this->setCurrentPage($currentPage);
    }

    /**
     *  For output links
     * @return HTML-code with navigation links
     */
    public function get()
    {
        # For the record links
        $links = null;

        # The resulting limit cycle
        $limits = $this->limits();

        $html = '<ul class="pagination">';
        # Generated links
        for ($page = $limits[0]; $page <= $limits[1]; $page++) {
            # If the current is the current page no link and class is added to the active
            if ($page == $this->current_page) {
                $links .= '<li class="active"><a href="#">' . $page . '</a></li>';
            } else {
                # Otherwise the generated link
                $links .= $this->generateHtml($page);
            }
        }

        # If the links are created
        if (!is_null($links)) {
            # If the current page not the first
            if ($this->current_page > 1)
                # Create a link "first"
                $links = $this->generateHtml(1, '&lt;') . $links;

            # If the current page not the first
            if ($this->current_page < $this->amount)
                # Create a link "last"
                $links .= $this->generateHtml($this->amount, '&gt;');
        }

        $html .= $links . '</ul>';

        # Return html
        return $html;
    }

    /**
     * To generate the HTML code for the link
     * @param integer $page - page number
     *
     * @return
     */
    private function generateHtml($page, $text = null)
    {
        # If link text is not specified
        if (!$text)
            # Specify that the text - figure page
            $text = $page;

        $currentURI = rtrim($_SERVER['REQUEST_URI'], '/') . '/';
        $currentURI = preg_replace('~/page-[0-9]+~', '', $currentURI);
        # The generated HTML code references and return
        return
            '<li><a href="' . $currentURI . $this->index . $page . '">' . $text . '</a></li>';
    }

    /**
     *  To realise where to start
     *
     * @return an array with the beginning and the end of the countdown
     */
    private function limits()
    {
        # Calculated to the left (so that the active link was in the middle)
        $left = $this->current_page - round($this->max / 2);

        # Computed origin
        $start = $left > 0 ? $left : 1;

        # If there is a minimum of $this->max pages
        if ($start + $this->max <= $this->amount) {
            # Assign the forward end of the loop $this->max pages, or just the minimum
            $end = $start > 1 ? $start + $this->max : $this->max;
        } else {
            # The end - total number of pages
            $end = $this->amount;

            # The beginning - minus the $this->max end
            $start = $this->amount - $this->max > 0 ? $this->amount - $this->max : 1;
        }

        # Return
        return
            array($start, $end);
    }

    /**
     * To set the current page
     *
     * @return
     */
    private function setCurrentPage($currentPage)
    {
        # Get the page number
        $this->current_page = $currentPage;

        # If the current page is greater than zero
        if ($this->current_page > 0) {
            # If current page less than total pages
            if ($this->current_page > $this->amount)
                # Set page to the last
                $this->current_page = $this->amount;
        } else
            # Set on the first page
            $this->current_page = 1;
    }

    /**
     * To obtain the total number of pages
     *
     * @return the number of pages
     */
    private function amount()
    {
        # Divide and return
        return ceil($this->total / $this->limit);
    }

}