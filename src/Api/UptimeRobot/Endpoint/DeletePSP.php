<?php

declare(strict_types=1);

/*
 * This file is part of the uptime-robot bundle package.
 * (c) Connect Holland.
 */

namespace ConnectHolland\UptimeRobotBundle\Api\UptimeRobot\Endpoint;

class DeletePSP extends \Jane\OpenApiRuntime\Client\BaseEndpoint implements \Jane\OpenApiRuntime\Client\Psr7Endpoint
{
    /**
     * Public status pages can be deleted using this method.
     *
     * @param array $formParameters {
     *
     *     @var string $api_key API key
     *     @var string $format Response format
     *     @var int $id ID of public status page to delete
     * }
     */
    public function __construct(array $formParameters = [])
    {
        $this->formParameters = $formParameters;
    }

    use \Jane\OpenApiRuntime\Client\Psr7EndpointTrait;

    public function getMethod(): string
    {
        return 'POST';
    }

    public function getUri(): string
    {
        return '/deletePSP';
    }

    public function getBody(\Symfony\Component\Serializer\SerializerInterface $serializer, $streamFactory = null): array
    {
        return $this->getFormBody();
    }

    public function getExtraHeaders(): array
    {
        return ['Accept' => ['application/json']];
    }

    protected function getFormOptionsResolver(): \Symfony\Component\OptionsResolver\OptionsResolver
    {
        $optionsResolver = parent::getFormOptionsResolver();
        $optionsResolver->setDefined(['api_key', 'format', 'id']);
        $optionsResolver->setRequired(['id']);
        $optionsResolver->setDefaults(['format' => 'json']);
        $optionsResolver->setAllowedTypes('api_key', ['string']);
        $optionsResolver->setAllowedTypes('format', ['string']);
        $optionsResolver->setAllowedTypes('id', ['int']);

        return $optionsResolver;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \ConnectHolland\UptimeRobotBundle\Api\UptimeRobot\Exception\DeletePSPBadRequestException
     * @throws \ConnectHolland\UptimeRobotBundle\Api\UptimeRobot\Exception\DeletePSPInternalServerErrorException
     *
     * @return \ConnectHolland\UptimeRobotBundle\Api\UptimeRobot\Model\PSPResponse|null
     */
    protected function transformResponseBody(string $body, int $status, \Symfony\Component\Serializer\SerializerInterface $serializer, ?string $contentType)
    {
        if (200 === $status) {
            return $serializer->deserialize($body, 'ConnectHolland\\UptimeRobotBundle\\Api\\UptimeRobot\\Model\\PSPResponse', 'json');
        }
        if (400 === $status) {
            throw new \ConnectHolland\UptimeRobotBundle\Api\UptimeRobot\Exception\DeletePSPBadRequestException();
        }
        if (500 === $status) {
            throw new \ConnectHolland\UptimeRobotBundle\Api\UptimeRobot\Exception\DeletePSPInternalServerErrorException();
        }
    }

    public function getAuthenticationScopes(): array
    {
        return [];
    }
}
