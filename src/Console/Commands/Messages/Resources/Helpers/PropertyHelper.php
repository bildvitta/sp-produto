<?php

namespace BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers;

use BildVitta\SpProduto\Models\AutomobileBrand;
use BildVitta\SpProduto\Models\AutomobileDifferential;
use BildVitta\SpProduto\Models\AutomobileModel;
use BildVitta\SpProduto\Models\AutomobileVersion;
use BildVitta\SpProduto\Models\EstateDifferential;
use BildVitta\SpProduto\Models\HubCompany;
use BildVitta\SpProduto\Models\Property;
use BildVitta\SpProduto\Models\PropertyAttachment;
use BildVitta\SpProduto\Models\PropertyHolder;
use BildVitta\SpProduto\Models\PropertyImage;
use stdClass;

trait PropertyHelper
{
    private function propertyUpdateOrCreate(stdClass $message): void
    {
        $hubCompany = HubCompany::withTrashed()
            ->where('uuid', $message->hub_company_uuid)
            ->first();

        $property = Property::updateOrCreate([
            'uuid' => $message->uuid,
        ], [
            'uuid' => $message->uuid,
            'kind' => $message->kind,
            'property_name' => $message->property_name,
            'description' => $message->description,
            'desired_value' => $message->desired_value,
            'rated_price' => $message->rated_price,
            'postal_code' => $message->postal_code,
            'address' => $message->address,
            'number' => $message->number,
            'city' => $message->city,
            'state' => $message->state,
            'complement' => $message->complement,
            'neighborhood' => $message->neighborhood,
            'estate_type' => $message->estate_type,
            'property_condition' => $message->property_condition,
            'useful_area' => $message->useful_area,
            'total_area' => $message->total_area,
            'average_property_tax' => $message->average_property_tax,
            'rooms_quantity' => $message->rooms_quantity,
            'suite_rooms_quantity' => $message->suite_rooms_quantity,
            'bathrooms_quantity' => $message->bathrooms_quantity,
            'garage_quantity' => $message->garage_quantity,
            'floor_number' => $message->floor_number,
            'floors_quantity' => $message->floors_quantity,
            'unities_floor_quantity' => $message->unities_floor_quantity,
            'is_condominium' => $message->is_condominium,
            'condominium_name' => $message->condominium_name,
            'average_condominium_price' => $message->average_condominium_price,
            'is_rented' => $message->is_rented,
            'rental_price' => $message->rental_price,
            'automobile_body_type' => $message->automobile_body_type,
            'automobile_type' => $message->automobile_type,
            'model_year' => $message->model_year,
            'fuel' => $message->fuel,
            'base_color' => $message->base_color,
            'commercial_color' => $message->commercial_color,
            'mileage' => $message->mileage,
            'hub_company_id' => $hubCompany?->id,
            'sales_code' => $message->sales_code,
            'property_purpose' => $message->property_purpose,
            'authorized_commercialization' => $message->authorized_commercialization,
            'iptu_payment_condition' => $message->iptu_payment_condition,
            'property_standard' => $message->property_standard,
            'location_standard' => $message->location_standard,
            'construction_year' => $message->construction_year,
            'property_renovation_year' => $message->property_renovation_year,
            'exclusivity' => $message->exclusivity,
            'accept_financing' => $message->accept_financing,
        ]);
        $this->propertyHolders($property, $message->property_holders);
        $this->propertyImages($property, $message->property_images);
        $this->propertyAttachments($property, $message->property_attachments);
        $this->propertyBrand($property, $message);
        $this->propertyModel($property, $message);
        $this->propertyVersion($property, $message);
        $this->propertyEstateDiferentials($property, $message);
        $this->propertyAutomobileDiferentials($property, $message);
    }

    private function propertyDelete(stdClass $message): void
    {
        Property::where('uuid', $message->uuid)->delete();
    }

    private function propertyHolders(Property $property, array $messagePropertyHolders): void
    {
        $propertyHolderUuids = [];
        foreach ($messagePropertyHolders as $messagePropertyHolder) {
            $propertyHolder = PropertyHolder::updateOrCreate([
                'holder_uuid' => $messagePropertyHolder->holder_uuid,
                'property_id' => $property->id,
            ], [
                'holder_uuid' => $messagePropertyHolder->holder_uuid,
                'property_id' => $property->id,
            ]);
            $propertyHolderUuids[] = $propertyHolder->holder_uuid;
        }
        PropertyHolder::where('property_id', $property->id)
            ->whereNotIn('holder_uuid', $propertyHolderUuids)
            ->delete();
    }

    private function propertyImages(Property $property, array $messagePropertyImages): void
    {
        $propertyImageIds = [];
        foreach ($messagePropertyImages as $messagePropertyImage) {
            $propertyImage = PropertyImage::updateOrCreate([
                'uuid' => $messagePropertyImage->uuid,
            ], [
                'uuid' => $messagePropertyImage->uuid,
                'property_id' => $property->id,
                'image' => $messagePropertyImage->image,
                'name' => $messagePropertyImage->name,
                'format' => $messagePropertyImage->format,
            ]);
            $propertyImageIds[] = $propertyImage->id;
        }
        PropertyImage::where('property_id', $property->id)
            ->whereNotIn('id', $propertyImageIds)
            ->delete();
    }

    private function propertyAttachments(Property $property, array $messagePropertyAttachments): void
    {
        $propertyAttachmentIds = [];
        foreach ($messagePropertyAttachments as $messagePropertyAttachment) {
            $propertyAttachment = PropertyAttachment::updateOrCreate([
                'uuid' => $messagePropertyAttachment->uuid,
            ], [
                'uuid' => $messagePropertyAttachment->uuid,
                'name' => $messagePropertyAttachment->name,
                'url' => $messagePropertyAttachment->url,
                'format' => $messagePropertyAttachment->format,
                'property_id' => $property->id,
            ]);
            $propertyAttachmentIds[] = $propertyAttachment->id;
        }
        PropertyAttachment::where('property_id', $property->id)
            ->whereNotIn('id', $propertyAttachmentIds)
            ->delete();
    }

    private function propertyBrand(Property $property, stdClass $message): void
    {
        $automobileBrand = null;

        if ($message->brand) {
            $automobileBrand = AutomobileBrand::updateOrCreate([
                'uuid' => $message->brand->uuid,
            ], [
                'uuid' => $message->brand->uuid,
                'type' => $message->brand->type,
                'label' => $message->brand->label,
                'slug' => $message->brand->slug,
            ]);
        }

        $property->brand()->associate($automobileBrand);
        $property->save();
    }

    private function propertyModel(Property $property, stdClass $message): void
    {
        $automobileModel = null;

        if ($message->model) {

            $automobileBrand = AutomobileBrand::updateOrCreate([
                'uuid' => $message->model->automobile_brand->uuid,
            ], [
                'uuid' => $message->model->automobile_brand->uuid,
                'type' => $message->model->automobile_brand->type,
                'label' => $message->model->automobile_brand->label,
                'slug' => $message->model->automobile_brand->slug,
            ]);

            $automobileModel = AutomobileModel::updateOrCreate([
                'uuid' => $message->model->uuid,
            ], [
                'uuid' => $message->model->uuid,
                'label' => $message->model->label,
                'slug' => $message->model->slug,
                'automobile_brand_id' => $automobileBrand->id,
            ]);

        }

        $property->model()->associate($automobileModel);
        $property->save();
    }

    private function propertyVersion(Property $property, stdClass $message): void
    {
        $automobileVersion = null;

        if ($message->version && $message->version->automobile_model && $message->version->automobile_model->automobile_brand) {

            $automobileBrand = AutomobileBrand::updateOrCreate([
                'uuid' => $message->version->automobile_model->automobile_brand->uuid,
            ], [
                'uuid' => $message->version->automobile_model->automobile_brand->uuid,
                'type' => $message->version->automobile_model->automobile_brand->type,
                'label' => $message->version->automobile_model->automobile_brand->label,
                'slug' => $message->version->automobile_model->automobile_brand->slug,
            ]);

            $automobileModel = AutomobileModel::updateOrCreate([
                'uuid' => $message->version->automobile_model->uuid,
            ], [
                'uuid' => $message->version->automobile_model->uuid,
                'label' => $message->version->automobile_model->label,
                'slug' => $message->version->automobile_model->slug,
                'automobile_brand_id' => $automobileBrand->id,
            ]);

            $automobileVersion = AutomobileVersion::updateOrCreate([
                'uuid' => $message->version->uuid,
            ], [
                'uuid' => $message->version->uuid,
                'label' => $message->version->label,
                'slug' => $message->version->slug,
                'automobile_model_id' => $automobileModel->id,
            ]);
        }

        $property->version()->associate($automobileVersion);
        $property->save();
    }

    private function propertyEstateDiferentials(Property $property, stdClass $message): void
    {
        $estateDiferentials = [];
        foreach ($message->estates_differentials as $estatesDifferential) {
            $estateDiferentials[] = EstateDifferential::updateOrCreate([
                'uuid' => $estatesDifferential->uuid,
            ], [
                'uuid' => $estatesDifferential->uuid,
                'label' => $estatesDifferential->label,
                'value' => $estatesDifferential->value,
            ])->id;
        }
        $property->estates_differentials()->sync($estateDiferentials);
    }

    private function propertyAutomobileDiferentials(Property $property, stdClass $message): void
    {
        $automobileDiferentials = [];
        foreach ($message->automobile_differentials as $automobileDifferential) {
            $automobileDiferentials[] = AutomobileDifferential::updateOrCreate([
                'uuid' => $automobileDifferential->uuid,
            ], [
                'uuid' => $automobileDifferential->uuid,
                'label' => $automobileDifferential->label,
                'value' => $automobileDifferential->value,
            ])->id;
        }
        $property->automobile_differentials()->sync($automobileDiferentials);
    }
}
