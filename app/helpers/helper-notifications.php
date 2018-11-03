<?php
/**
 * Function to render a HTML that is wrapped with a default blade template.
 * @param $content
 * @return string
 */
function wrapContent($content)
{
    $template = "emails.layouts.notificationtemplate";
    return View::make($template)->with('content', $content)->render();
}

/**
 * Function to return an array of notification contents where codes are replaced with actual content.
 * @param Notificationtemplate $template
 * @param array $subject_replaces
 * @param array $email_replaces
 * @param array $sms_replaces
 * @return array
 */
function loadNotificationContents(Notificationtemplate $template, $subject_replaces = [], $email_replaces = [], $sms_replaces = [])
{
    return ['subject'       => multipleStrReplace($template->subject, $subject_replaces),
        'email_content' => wrapContent(multipleStrReplace($template->email_content, $email_replaces)),
        'sms_content'   => multipleStrReplace($template->sms_content, $sms_replaces)
    ];

}

/**
 * @param Newsarchive $newsarchive
 * @return array
 */
// function notificationNewsarchiveCreated(Newsarchive $newsarchive) {
//
//     $notificationtemplate_id = 1; // Define notification template
//     $ret = ['subject' => null, 'email_content' => null, 'sms_content' => null];
//
//     if ($template = Notificationtemplate::remember(cacheTime('notification-template'))->find($notificationtemplate_id)) {
//
//         /*********************************************
//          *  Prepare subject
//          ********************************************/
//         $subject_replaces = [ // Leave an empty array if no string replace is required.
//             "{{#ID}}" => $newsarchive->id,
//         ];
//
//         /*********************************************
//          *  Prepare HTML
//          ********************************************/
//         $email_replaces = [ // Leave an empty array if no string replace is required.
//             "{{#NAME}}" => $newsarchive->name,
//             "{{#NEWSPAPER}}" => isset($newsarchive->newspaper->name) ? $newsarchive->newspaper->name : '',
//             "{{#PUBLISH_DATE}}" => $newsarchive->publish_date,
//             "{{#FACILITY_LIST}}" => trim($newsarchive->facility_id_1_name . "," . $newsarchive->facility_id_2_name . "," . $newsarchive->facility_id_3_name, ", "),
//             "{{#NEWS_TYPE}}" => $newsarchive->news_type,
//             "{{#NEWS_CATEGORY}}" => $newsarchive->news_category,
//             "{{#TAGS}}" => trim($newsarchive->tag_words, ', '),
//             "{{#VIEW_URL}}" => route('newsarchives.details', $newsarchive->id),
//             "{{#EDIT_URL}}" => route('newsarchives.edit', $newsarchive->id),
//         ];
//
//         /*********************************************
//          *  Prepare SMS
//          ********************************************/
//         $sms_replaces = [  // Leave an empty array if no string replace is required.
//             "{{#ID}}" => $newsarchive->id,
//         ];
//
//         $ret = loadNotificationContents($template, $subject_replaces, $email_replaces, $sms_replaces);
//
//     }
//     return $ret;
// }

/**
 * @param Shoporder $shoporder
 * @return array
 */
function notificationOrderSaved(Shoporder $shoporder)
{

    $notificationtemplate_id = 1; // Define notification template
    $ret = ['subject' => null, 'email_content' => null, 'sms_content' => null];

    if ($template = Notificationtemplate::remember(cacheTime('notification-template'))->find($notificationtemplate_id)) {

        /*********************************************
         *  Prepare subject
         ********************************************/
        $subject_replaces = [ // Leave an empty array if no string replace is required.
            "{{#SHOPORDER_ID}}" => $shoporder->id,
        ];

        /*********************************************
         *  Prepare HTML
         ********************************************/
        $email_replaces = [ // Leave an empty array if no string replace is required.
            "{{#SHOPORDER_ID}}"                  => $shoporder->id,
            "{{#SHOPORDER_STATUS}}"              => $shoporder->status,
            "{{#SHOPORDER_BUYER_ID}}"            => $shoporder->buyer_id,
            "{{#SHOPORDER_FIRST_NAME}}"          => $shoporder->first_name,
            "{{#SHOPORDER_LAST_NAME}}"           => $shoporder->last_name,
            "{{#SHOPORDER_SHIPPING_FIRST_NAME}}" => $shoporder->shipping_first_name,
            "{{#SHOPORDER_SHIPPING_LAST_NAME}}"  => $shoporder->shipping_last_name,
            "{{#SHOPORDER_BILLING_ADDRESS}}"     => $shoporder->address1,
            "{{#SHOPORDER_SHIPPING_ADDRESS}}"    => $shoporder->shipping_address1,
            "{{#SHOPORDER_BILLING_ADDRESS_2}}"   => $shoporder->address2,
            "{{#SHOPORDER_SHIPPING_ADDRESS_2}}"  => $shoporder->shipping_address2,
            "{{#SHOPORDER_BILLING_CITY}}"        => $shoporder->city,
            "{{#SHOPORDER_SHIPPING_CITY}}"       => $shoporder->shipping_city,
            "{{#SHOPORDER_BILLING_COUNTY}}"      => $shoporder->county,
            "{{#SHOPORDER_SHIPPING_COUNTY}}"     => $shoporder->shipping_county,
            "{{#SHOPORDER_BILLING_ZIPCODE}}"     => $shoporder->zip_code,
            "{{#SHOPORDER_SHIPPING_ZIPCODE}}"    => $shoporder->shipping_zip_code,
            "{{#SHOPORDER_BILLING_COUNTRY}}"     => $shoporder->country_name,
            "{{#SHOPORDER_SHIPPING_COUNTRY}}"    => $shoporder->shipping_country_name,
            "{{#SHOPORDER_BILLING_PHONE}}"       => $shoporder->phone,
            "{{#SHOPORDER_SHIPPING_PHONE}}"      => $shoporder->shipping_phone,
            "{{#SHOPORDER_SHIPPINGMETHOD_COST}}" => $shoporder->shippingmethod_cost,
            "{{#SHOPORDER_SUBTOTALl}}"           => $shoporder->subtotal
        ];

        $email_replaces = array_merge($email_replaces, [
            "{{#CARTITEMS}}" => View::make('emails.shoporders.order-save')->with('shoporder', $shoporder)->render(),
        ]);

        /*********************************************
         *  Prepare SMS
         ********************************************/
        $sms_replaces = [  // Leave an empty array if no string replace is required.

        ];

        $ret = loadNotificationContents($template, $subject_replaces, $email_replaces, $sms_replaces);

    }
    return $ret;
}

/**
 * @param Message $message
 * @return array
 */
function notificationMessageCreated(Message $message) {
    $notificationtemplate_id = 2; // Define notification template
    $ret = ['subject' => null, 'email_content' => null, 'sms_content' => null];
    if ($template = Notificationtemplate::remember(cacheTime('notification-template'))->find($notificationtemplate_id)) {

        /*********************************************
         *  Prepare subject
         ********************************************/
        $subject_replaces = [ // Leave an empty array if no string replace is required.
            "{{#MESSAGE_ID}}" => $message->id,
        ];

        /*********************************************
         *  Prepare HTML
         ********************************************/
        $email_replaces = [ // Leave an empty array if no string replace is required.
            "{{#MESSAGE_ID}}" => $message->id,
            "{{#MESSAGE_BODY}}" => $message->body,
            "{{#DETAILS_URL}}" => route('messages.edit', $message->id),
        ];

        /*********************************************
         *  Prepare SMS
         ********************************************/
        $sms_replaces = [  // Leave an empty array if no string replace is required.

        ];

        $ret = loadNotificationContents($template, $subject_replaces, $email_replaces, $sms_replaces);
    }
    return $ret;
}
