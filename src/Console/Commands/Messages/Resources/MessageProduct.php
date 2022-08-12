<?php

namespace BildVitta\SpProduto\Console\Commands\Messages\Resources;

use App\Components\Iss\IssComponent;
use App\Models\HubCompany;
use BildVitta\SpProduto\Models\RealEstateDevelopment;
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
use BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers\StageHelper;
use BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers\TypologyHelper;
use BildVitta\SpProduto\Console\Commands\Messages\Resources\Helpers\UnitHelper;
use PhpAmqpLib\Message\AMQPMessage;
use stdClass;
use Throwable;

class MessageProduct
{
    use StageHelper;
    use ParameterHelper;
    use InsuranceHelper;
    use ProposalModelHelper;
    use BuyingOptionHelper;
    use TypologyHelper;
    use MirrorHelper;
    use LogHelper;
    use CharacteristicHelper;
    use AccessoriesHelper;
    use BlueprintHelper;
    use UnitHelper;
    use MediaHelper;
    use DocumentHelper;

    /**
     * @var string
     */
    public const UPDATED = 'real_estate_developments.updated';

    /**
     * @var string
     */
    public const CREATED = 'real_estate_developments.created';

    /**
     * @var string
     */
    public const DELETED = 'real_estate_developments.deleted';

    /**
     * @param AMQPMessage $message
     * @return void
     */
    public function process(AMQPMessage $message): void
    {
        try {
            $message->ack();
            $properties = $message->get_properties();
            $messageData = json_decode($message->getBody());
            $operation = $properties['type'];

            switch ($operation) {
                case self::CREATED:
                case self::UPDATED:
                    $this->updateOrCreate($messageData);
                    break;
                case self::DELETED:
                    $this->delete($messageData);
                    break;
                default:
                    break;
            }
        } catch(Throwable $exception) {
            $this->logError($exception, $messageData);
            if (app()->isLocal()) {
                throw $exception;
            }
        }
    }

    /**
     * @param stdClass $message
     * @return void
     */
    private function updateOrCreate(stdClass $message): void
    {
        $realEstateDevelopment = RealEstateDevelopment::updateOrCreate([
            'uuid' => $message->uuid,
        ], [
            'uuid' => $message->uuid,
            'hub_company_id' => $this->getHubCompanyId($message->hub_company_uuid),
            'name' => $message->real_estate,
        ]);
        if (isset($message->construction_address)) {
            $realEstateDevelopment->address = $message->construction_address;
        }
        if (isset($message->construction_street_number)) {
            $realEstateDevelopment->street_number = $message->construction_street_number;
        }
        if (isset($message->construction_neighborhood)) {
            $realEstateDevelopment->neighborhood = $message->construction_neighborhood;
        }
        if (isset($message->construction_city)) {
            $realEstateDevelopment->city = $message->construction_city;
        }
        if (isset($message->construction_state)) {
            $realEstateDevelopment->state = $message->construction_state;
        }
        if (isset($message->real_estate_logo)) {
            $realEstateDevelopment->real_estate_logo = $message->real_estate_logo;
        }
        if (isset($message->external_code)) {
            $realEstateDevelopment->external_code = $message->external_code;
        }
        if (isset($message->external_num_code)) {
            $realEstateDevelopment->external_num_code = $message->external_num_code;
        }
        if (isset($message->external_company_code)) {
            $realEstateDevelopment->external_company_code = $message->external_company_code;
        }
        if (isset($message->external_subsidiary_code)) {
            $realEstateDevelopment->external_subsidiary_code = $message->external_subsidiary_code;
        }

        $realEstateDevelopment->save();
        
        if (isset($message->stages)) {
            $this->stages($realEstateDevelopment, $message);
        }
        if (isset($message->last_parameter)) {
            //$this->lastParameter($realEstateDevelopment, $message);
        }
        if (isset($message->insurances[0], $message->insurance_companies[0])) {
            $this->insurances($realEstateDevelopment, $message);
        }
        if (isset($message->real_estate_proposal_models)) {
            $this->proposalModels($realEstateDevelopment, $message);
        }
        if (isset($message->buying_options)) {
            $this->buyingOptions($realEstateDevelopment, $message);
        }
        if (isset($message->typologies)) {
            $this->typologies($realEstateDevelopment, $message);
        }
        if (isset($message->mirrors)) {
            $this->mirrors($realEstateDevelopment, $message);
        }
        if (isset($message->characteristics)) {
            $this->characteristics($realEstateDevelopment, $message);
        }
        if (isset($message->accessories)) {
            $this->accessories($realEstateDevelopment, $message);
        }
        if (isset($message->blueprints)) {
            $this->blueprints($realEstateDevelopment, $message);
        }
        if (isset($message->units)) {
            $this->units($realEstateDevelopment, $message);
        }
        if (isset($message->medias)) {
            $this->medias($realEstateDevelopment, $message);
        }
        if (isset($message->documents)) {
            $this->documents($realEstateDevelopment, $message);
        }
    }

    /**
     * @param stdClass $message
     * @return void
     */
    private function delete(stdClass $message): void
    {
        RealEstateDevelopment::where('uuid', $message->uuid)->delete();
    }

    /**
     * @param string $hubCompanyUuid
     * @return int
     */
    private function getHubCompanyId(string $hubCompanyUuid): int
    {
        $hubCompany = HubCompany::whereUuid($hubCompanyUuid)->first();
        if (!$hubCompany) {
            $responseCompany = (new IssComponent())->hub()->findCompany($hubCompanyUuid);
            $hubCompany = HubCompany::create([
                'uuid' => $hubCompanyUuid,
                'name' => $responseCompany->result->name
            ]);
        }

        return $hubCompany->id;
    }
}
