<?php

namespace BildVitta\SpProduto\Console\Commands\Messages\Resources;

use BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers\Helpers;
use PhpAmqpLib\Message\AMQPMessage;
use stdClass;
use Throwable;

class RealEstateDevelopmentMessageProcessor
{
    use Helpers;

    public const REAL_ESTATE_DEVELOPMENTS = 'real_estate_developments';

    public const UNITS = 'units';

    public const CHARACTERISTICS = 'characteristics';

    public const REAL_ESTATE_DEVELOPMENT_CHARACTERISTICS = 'real_estate_development_characteristics';

    public const PROPOSAL_MODELS = 'proposal_models';

    public const BUYING_OPTIONS = 'buying_options';

    public const PROPERTIES = 'properties';

    public const CATEGORIES = 'categories';

    public const ACCESSORIES = 'accessories';

    public const INSURANCE_COMPANIES = 'insurance_companies';

    public const ATTRIBUTES = 'attributes';

    public const UPDATED = 'updated';

    public const CREATED = 'created';

    public const DELETED = 'deleted';

    public function process(AMQPMessage $message): void
    {
        $message->ack();
        $messageData = null;
        $messageBody = null;
        try {
            $properties = $message->get_properties();
            $properties = explode('.', $properties['type']);
            $type = $properties[0];
            $operation = $properties[1];
            $messageBody = $message->getBody();
            $messageData = json_decode($messageBody);
            switch ($type) {
                case self::REAL_ESTATE_DEVELOPMENTS:
                    $this->processRealEstateDevelopment($operation, $messageData);
                    break;
                case self::UNITS:
                    $this->processUnit($operation, $messageData);
                    break;
                case self::CHARACTERISTICS:
                    $this->processCharacteristic($operation, $messageData);
                    break;
                case self::REAL_ESTATE_DEVELOPMENT_CHARACTERISTICS:
                    $this->processRealEstateDevelopmentCharacteristic($operation, $messageData);
                    break;
                case self::PROPERTIES:
                    $this->processProperty($operation, $messageData);
                    break;
                case self::PROPERTIES:
                    $this->processProperty($operation, $messageData);
                    break;
                case self::PROPOSAL_MODELS:
                    $this->processProposalModels($operation, $messageData);
                    break;
                case self::BUYING_OPTIONS:
                    $this->processBuyingOptions($operation, $messageData);
                    break;
                case self::CATEGORIES:
                    $this->processCategories($operation, $messageData);
                    break;
                case self::ACCESSORIES:
                    $this->processAccessories($operation, $messageData);
                    break;
                case self::INSURANCE_COMPANIES:
                    $this->processInsuranceCompanies($operation, $messageData);
                    break;
                case self::ATTRIBUTES:
                    $this->processAttributes($operation, $messageData);
                    break;
            }
        } catch (Throwable $exception) {
            $this->logError($exception, $messageBody);
            if (app()->isLocal()) {
                throw $exception;
            }
        }
    }

    private function processRealEstateDevelopment(string $operation, stdClass $messageData): void
    {
        switch ($operation) {
            case self::CREATED:
            case self::UPDATED:
                $this->realEstateDevelopmentUpdateOrCreate($messageData);
                break;
            case self::DELETED:
                $this->realEstateDevelopmentDelete($messageData);
                break;
        }
    }

    private function processUnit(string $operation, stdClass $messageData): void
    {
        if ($this->configHas('units')) {
            switch ($operation) {
                case self::CREATED:
                case self::UPDATED:
                    $this->unitUpdateOrCreate($messageData);
                    break;
                case self::DELETED:
                    $this->unitDelete($messageData);
                    break;
            }
        }
    }

    private function processCharacteristic(string $operation, stdClass $messageData): void
    {
        if ($this->configHas('characteristics')) {
            switch ($operation) {
                case self::CREATED:
                case self::UPDATED:
                    $this->characteristicUpdateOrCreate($messageData);
                    break;
                case self::DELETED:
                    $this->characteristicDelete($messageData);
                    break;
            }
        }
    }

    private function processProperty(string $operation, stdClass $messageData): void
    {
        if ($this->configHas('properties')) {
            switch ($operation) {
                case self::CREATED:
                case self::UPDATED:
                    $this->propertyUpdateOrCreate($messageData);
                    break;
                case self::DELETED:
                    $this->propertyDelete($messageData);
                    break;
            }
        }
    }

    private function processProposalModels(string $operation, stdClass $messageData): void
    {
        if ($this->configHas('proposal_models')) {
            switch ($operation) {
                case self::CREATED:
                case self::UPDATED:
                    $this->proposalModelUpdateOrCreate($messageData);
                    break;
                case self::DELETED:
                    $this->proposalModelDelete($messageData);
                    break;
            }
        }
    }

    private function processBuyingOptions(string $operation, stdClass $messageData): void
    {
        if ($this->configHas('buying_options')) {
            switch ($operation) {
                case self::CREATED:
                case self::UPDATED:
                    $this->buyingOptionUpdateOrCreate($messageData);
                    break;
                case self::DELETED:
                    $this->buyingOptionDelete($messageData);
                    break;
            }
        }
    }

    private function processCategories(string $operation, stdClass $messageData): void
    {
        if ($this->configHas('accessories')) {
            switch ($operation) {
                case self::CREATED:
                case self::UPDATED:
                    $this->categoryUpdateOrCreate($messageData);
                    break;
                case self::DELETED:
                    $this->categoryDelete($messageData);
                    break;
            }
        }
    }

    private function processAccessories(string $operation, stdClass $messageData): void
    {
        if ($this->configHas('accessories')) {
            switch ($operation) {
                case self::CREATED:
                case self::UPDATED:
                    $this->accessoryUpdateOrCreate($messageData);
                    break;
                case self::DELETED:
                    $this->accessoryDelete($messageData);
                    break;
            }
        }
    }

    private function processInsuranceCompanies(string $operation, stdClass $messageData): void
    {
        if ($this->configHas('insurances')) {
            switch ($operation) {
                case self::CREATED:
                case self::UPDATED:
                    $this->insuranceCompanyUpdateOrCreate($messageData);
                    break;
                case self::DELETED:
                    $this->insuranceCompanyDelete($messageData);
                    break;
            }
        }
    }

    private function processRealEstateDevelopmentCharacteristic(string $operation, stdClass $messageData): void
    {
        if ($this->configHas('characteristics')) {
            switch ($operation) {
                case self::CREATED:
                case self::UPDATED:
                    $this->realEstateDevelopmentCharacteristicUpdateOrCreate($messageData);
                    break;
                case self::DELETED:
                    $this->realEstateDevelopmentCharacteristicDelete($messageData);
                    break;
            }
        }
    }

    private function processAttributes(string $operation, stdClass $messageData): void
    {
        if ($this->configHas('typologies')) {
            switch ($operation) {
                case self::CREATED:
                case self::UPDATED:
                    $this->attributeUpdateOrCreate($messageData);
                    break;
                case self::DELETED:
                    $this->attributeDelete($messageData);
                    break;
            }
        }
    }
}
