<?php

namespace BildVitta\SpProduto\Console\Commands\Messages\Resources;

use BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers\AccessoriesHelper;
use BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers\BlueprintHelper;
use BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers\BuyingOptionHelper;
use BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers\CharacteristicHelper;
use BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers\DocumentHelper;
use BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers\InsuranceHelper;
use BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers\LogHelper;
use BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers\MediaHelper;
use BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers\MirrorHelper;
use BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers\ParameterHelper;
use BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers\ProposalModelHelper;
use BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers\RealEstateDevelopmentHelper;
use BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers\SellableHelper;
use BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers\StageHelper;
use BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers\Tools;
use BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers\TypologyHelper;
use BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers\UnitHelper;
use PhpAmqpLib\Message\AMQPMessage;
use stdClass;
use Throwable;

class RealEstateDevelopmentMessageProcessor
{
    use AccessoriesHelper;
    use BlueprintHelper;
    use BuyingOptionHelper;
    use CharacteristicHelper;
    use DocumentHelper;
    use InsuranceHelper;
    use LogHelper;
    use MediaHelper;
    use MirrorHelper;
    use ParameterHelper;
    use ProposalModelHelper;
    use RealEstateDevelopmentHelper;
    use SellableHelper;
    use StageHelper;
    use Tools;
    use TypologyHelper;
    use UnitHelper;

    /**
     * @var string
     */
    public const REAL_ESTATE_DEVELOPMENTS = 'real_estate_developments';

    /**
     * @var string
     */
    public const UNITS = 'units';

    /**
     * @var string
     */
    public const CHARACTERISTICS = 'characteristics';

    /**
     * @var string
     */
    public const UPDATED = 'updated';

    /**
     * @var string
     */
    public const CREATED = 'created';

    /**
     * @var string
     */
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
}
