<?php

// pagination variables
$number_of_pages = $this->data['number_of_pages'];
$page_number = $this->data['page_number'];
$items_per_page = $this->data['items_per_page'];
$params = (isset($params))?$params:"";
// create pagination object
new Paginator($page_number, $items_per_page, $number_of_pages, $this->path("$this->view$params"));