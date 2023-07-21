<?php

namespace App\Entity;

use App\Repository\RequestLogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RequestLogRepository::class)]
class RequestLog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $providerName = null;

    #[ORM\Column(length: 255)]
    private ?string $requestName = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $requestBody = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $responseBody = null;

    #[ORM\Column]
    private ?int $responseType = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProviderName(): ?string
    {
        return $this->providerName;
    }

    public function setProviderName(string $providerName): static
    {
        $this->providerName = $providerName;

        return $this;
    }

    public function getRequestName(): ?string
    {
        return $this->requestName;
    }

    public function setRequestName(string $requestName): static
    {
        $this->requestName = $requestName;

        return $this;
    }

    public function getRequestBody(): ?string
    {
        return $this->requestBody;
    }

    public function setRequestBody(string $requestBody): static
    {
        $this->requestBody = $requestBody;

        return $this;
    }

    public function getResponseBody(): ?string
    {
        return $this->responseBody;
    }

    public function setResponseBody(string $responseBody): static
    {
        $this->responseBody = $responseBody;

        return $this;
    }

    public function getResponseType(): ?int
    {
        return $this->responseType;
    }

    public function setResponseType(int $responseType): static
    {
        $this->responseType = $responseType;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
