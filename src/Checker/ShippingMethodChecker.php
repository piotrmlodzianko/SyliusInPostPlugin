<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
 */

declare(strict_types=1);

namespace BitBag\SyliusInPostPlugin\Checker;

use BitBag\SyliusInPostPlugin\EventListener\ShippingExportEventListener;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\ShipmentInterface;

final class ShippingMethodChecker implements ShippingMethodCheckerInterface
{
    public function isInPost(OrderInterface $order): bool
    {
        return $order->getShipments()->exists(function (int $index, ShipmentInterface $shipment): bool {
            if (null === $shipment->getMethod()) {
                return false;
            }

            $shipmentCode = $shipment->getMethod()->getCode();
            $isInPostPoint = str_starts_with($shipmentCode, ShippingExportEventListener::INPOST_POINT_SHIPPING_METHOD_CODE_PREFIX);
            $isInPostCourier = str_starts_with($shipmentCode, ShippingExportEventListener::INPOST_COURIER_SHIPPING_METHOD_CODE_PREFIX);

            return $isInPostPoint || $isInPostCourier;
        });
    }
}
