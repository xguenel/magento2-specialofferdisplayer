<?php
declare(strict_types=1);

namespace Dnd\SpecialOfferDisplayer\Api\Data;

interface OfferInterface
{
    const ID = 'offer_id';
    const OFFER_LABEL = 'offer_label';
    const CONTENT = 'content';
    const IMAGE_FILE_NAME = 'image_file_name';
    const REDIRECTION_LINK = 'redirection_link';
    const CATEGORY_LIST = 'category_list';
    const STARTING_DISPLAY_AT = 'starting_display_at';
    const ENDING_DISPLAY_AT = 'ending_display_at';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function getId();

    public function getOfferLabel();

    public function getContent();

    public function getImageFileName();

    public function getRedirectionLink();

    public function getCategoryList();

    public function getStartingDisplayAt();

    public function getEndingDisplayAt();

    public function getCreatedAt();

    public function getUpdatedAt();


    public function setId($id);

    public function setOfferLabel($offerLabel);

    public function setContent($content);

    public function setImageFileName($imageFileName);

    public function setRedirectionLink($redirectionLink);

    public function setCategoryList($categoryList);

    public function setStartingDisplayAt($startingDisplayAt);

    public function setEndingDisplayAt($endingDisplayAt);
}







