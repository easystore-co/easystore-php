<?php

namespace EasyStore;


class EasyStore
{

  protected $config;
  protected $resources = [];

  public function __construct($config)
  {

    ##config
    #clientID
    #clientSecret
    #shopUrl
    #accessToken

    $this->config = $config;
  }

  public function auth(){

    $class = __NAMESPACE__ . "\Helpers\Auth";

    return new $class($this->config);

  }



  public function __call($name, $arguments)
  {

    $name = ucwords($name);

    if (empty($this->$name)) {

      $resourceClass = __NAMESPACE__ . "\Resources\\" . $name;

      $this->$name = new $resourceClass($this->config);

    }

    return $this->$name;

  }

}



// ==========HELPERS=================
// Auth




// ==========RESOURCES==============
// AbandonedCheckout
// ApplicationCharge
// Blog
// Blog -> Article
// Blog -> Article -> Event
// Blog -> Article -> Metafield
// Blog -> Event
// Blog -> Metafield
// CarrierService
// Collect
// Comment
// Comment -> Event
// Country
// Country -> Province
// Currency
// CustomCollection
// CustomCollection -> Event
// CustomCollection -> Metafield
// Customer
// Customer -> Address
// Customer -> Metafield
// Customer -> Order
// CustomerSavedSearch
// CustomerSavedSearch -> Customer
// DraftOrder
// Discount (Shopify Plus Only)
// DiscountCode
// Event
// FulfillmentService
// GiftCard (Shopify Plus Only)
// InventoryItem
// InventoryLevel
// Location (read only)
// Location -> InventoryLevel
// Metafield
// Multipass (Shopify Plus Only, API not available yet)
// Order
// Order -> Fulfillment
// Order -> Fulfillment -> Event
// Order -> Risk
// Order -> Refund
// Order -> Transaction
// Order -> Event
// Order -> Metafield
// Page
// Page -> Event
// Page -> Metafield
// Policy (read only)
// Product
// Product -> Image
// Product -> Variant
// Product -> Variant -> Metafield
// Product -> Event
// Product -> Metafield
// ProductListing
// ProductVariant
// ProductVariant -> Metafield
// RecurringApplicationCharge
// RecurringApplicationCharge -> UsageCharge
// Redirect
// ScriptTag
// ShippingZone (read only)
// Shop (read only)
// SmartCollection
// SmartCollection -> Event
// ShopifyPayment
// ShopifyPayment -> Dispute (read only)
// Theme
// Theme -> Asset
// User (read only, Shopify Plus Only)
// Webhook
// GraphQL
