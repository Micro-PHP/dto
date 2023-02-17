<?php

/**
 * This file is auto-generated.
 */

declare(strict_types=1);

namespace Transfer\Simple;

use DateTimeInterface;

final class SimpleUserTransfer extends \Micro\Library\DTO\Object\AbstractDto
{
    protected SimpleObjectTransfer|null $parent = null;

    #[\Symfony\Component\Validator\Constraints\Length(groups: ['Default'], max: 50, min: 6)]
    #[\Symfony\Component\Validator\Constraints\Regex(groups: ['Default'], pattern: '/^(.[aA-zA]+)$/', match: true)]
    protected string|null $username = null;

    #[\Symfony\Component\Validator\Constraints\NotBlank(groups: ['Default'], allowNull: false)]
    #[\Symfony\Component\Validator\Constraints\GreaterThan(groups: ['Default'], value: 18)]
    #[\Symfony\Component\Validator\Constraints\LessThan(groups: ['Default'], value: 100)]
    protected int|null $age = null;

    #[\Symfony\Component\Validator\Constraints\Email(groups: ['Default'], mode: 'html5')]
    #[\Symfony\Component\Validator\Constraints\NotBlank(groups: ['Default'], allowNull: false)]
    protected string|null $email = null;

    #[\Symfony\Component\Validator\Constraints\Ip(groups: ['Default'], version: '4')]
    protected string|null $ip = null;

    #[\Symfony\Component\Validator\Constraints\Hostname(groups: ['Default'], requireTld: false)]
    protected string|null $hostname = null;

    #[\Symfony\Component\Validator\Constraints\Regex(groups: ['Default'], pattern: '/^(.[a-z])+$/', match: true)]
    protected string|null $sometext = null;

    #[\Symfony\Component\Validator\Constraints\Url(groups: ['Default'], relativeProtocol: true)]
    protected string|null $url = null;

    #[\Symfony\Component\Validator\Constraints\NotBlank(groups: ['Default'], allowNull: false)]
    #[\Symfony\Component\Validator\Constraints\Json(groups: ['Default'])]
    protected string|null $json = null;

    #[\Symfony\Component\Validator\Constraints\NotBlank(groups: ['Default'], allowNull: false)]
    #[\Symfony\Component\Validator\Constraints\Uuid(groups: ['Default'], versions: [1, 2, 3, 4, 5, 6], strict: true)]
    protected string|null $uuid = null;

    #[\Symfony\Component\Validator\Constraints\DateTime(groups: ['Default'], format: 'Y-m-d H:i:s')]
    protected string|null $created_at = null;

    #[\Symfony\Component\Validator\Constraints\Date(groups: ['Default'])]
    protected string|null $updated_at = null;

    #[\Symfony\Component\Validator\Constraints\Timezone(groups: ['Default'], countryCode: 'BY', intlCompatible: true, zone: 4096)]
    protected string|null $timezone = null;

    #[\Symfony\Component\Validator\Constraints\NotBlank(groups: ['Default'], allowNull: false)]
    #[\Symfony\Component\Validator\Constraints\CardScheme(groups: ['Default'], schemes: ['MASTERCARD'])]
    #[\Symfony\Component\Validator\Constraints\Luhn(groups: ['Default'])]
    protected string|null $card_scheme = null;

    #[\Symfony\Component\Validator\Constraints\NotBlank(groups: ['Default'], allowNull: false)]
    #[\Symfony\Component\Validator\Constraints\Bic(groups: ['Default'])]
    protected string|null $bic = null;

    #[\Symfony\Component\Validator\Constraints\NotBlank(groups: ['Default'], allowNull: false)]
    #[\Symfony\Component\Validator\Constraints\Currency(groups: ['Default'])]
    protected string|null $currency = null;

    #[\Symfony\Component\Validator\Constraints\NotBlank(groups: ['Default'], allowNull: false)]
    #[\Symfony\Component\Validator\Constraints\Iban(groups: ['Default'])]
    protected string|null $iban = null;

    #[\Symfony\Component\Validator\Constraints\NotBlank(groups: ['Default'], allowNull: false)]
    #[\Symfony\Component\Validator\Constraints\Isbn(groups: ['Default'], type: 'isbn13')]
    protected string|null $isbn = null;

    #[\Symfony\Component\Validator\Constraints\NotBlank(groups: ['Default'], allowNull: false)]
    #[\Symfony\Component\Validator\Constraints\Issn(groups: ['Default'])]
    protected string|null $issn = null;

    #[\Symfony\Component\Validator\Constraints\NotBlank(groups: ['Default'], allowNull: false)]
    #[\Symfony\Component\Validator\Constraints\Isin(groups: ['Default'])]
    protected string|null $isin = null;

    #[\Symfony\Component\Validator\Constraints\NotBlank(groups: ['Default'], allowNull: false)]
    #[\Symfony\Component\Validator\Constraints\Choice(groups: ['Default'], choices: [1, 'example', 0.001, true])]
    protected string|int|float|array|null $choice = null;

    #[\Symfony\Component\Validator\Constraints\Expression(groups: ['Default'], expression: 'this.getChoice() === excepted', values: ['excepted' => 'example'])]
    protected string|int|null $expression = null;

    public function getParent(): SimpleObjectTransfer|null
    {
        return $this->parent;
    }

    public function getUsername(): string|null
    {
        return $this->username;
    }

    public function getAge(): int|null
    {
        return $this->age;
    }

    public function getEmail(): string|null
    {
        return $this->email;
    }

    public function getIp(): string|null
    {
        return $this->ip;
    }

    public function getHostname(): string|null
    {
        return $this->hostname;
    }

    public function getSometext(): string|null
    {
        return $this->sometext;
    }

    public function getUrl(): string|null
    {
        return $this->url;
    }

    public function getJson(): string|null
    {
        return $this->json;
    }

    public function getUuid(): string|null
    {
        return $this->uuid;
    }

    public function getCreatedAt(): string|null
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): string|null
    {
        return $this->updated_at;
    }

    public function getTimezone(): string|null
    {
        return $this->timezone;
    }

    public function getCardScheme(): string|null
    {
        return $this->card_scheme;
    }

    public function getBic(): string|null
    {
        return $this->bic;
    }

    public function getCurrency(): string|null
    {
        return $this->currency;
    }

    public function getIban(): string|null
    {
        return $this->iban;
    }

    public function getIsbn(): string|null
    {
        return $this->isbn;
    }

    public function getIssn(): string|null
    {
        return $this->issn;
    }

    public function getIsin(): string|null
    {
        return $this->isin;
    }

    public function getChoice(): string|int|float|array|null
    {
        return $this->choice;
    }

    public function getExpression(): string|int|null
    {
        return $this->expression;
    }

    public function setParent(SimpleObjectTransfer|null $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function setUsername(string|null $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function setAge(int|null $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function setEmail(string|null $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function setIp(string|null $ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    public function setHostname(string|null $hostname): self
    {
        $this->hostname = $hostname;

        return $this;
    }

    public function setSometext(string|null $sometext): self
    {
        $this->sometext = $sometext;

        return $this;
    }

    public function setUrl(string|null $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function setJson(string|null $json): self
    {
        $this->json = $json;

        return $this;
    }

    public function setUuid(string|null $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function setCreatedAt(string|null $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function setUpdatedAt(string|null $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function setTimezone(string|null $timezone): self
    {
        $this->timezone = $timezone;

        return $this;
    }

    public function setCardScheme(string|null $card_scheme): self
    {
        $this->card_scheme = $card_scheme;

        return $this;
    }

    public function setBic(string|null $bic): self
    {
        $this->bic = $bic;

        return $this;
    }

    public function setCurrency(string|null $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function setIban(string|null $iban): self
    {
        $this->iban = $iban;

        return $this;
    }

    public function setIsbn(string|null $isbn): self
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function setIssn(string|null $issn): self
    {
        $this->issn = $issn;

        return $this;
    }

    public function setIsin(string|null $isin): self
    {
        $this->isin = $isin;

        return $this;
    }

    public function setChoice(string|int|float|array|null $choice): self
    {
        $this->choice = $choice;

        return $this;
    }

    public function setExpression(string|int|null $expression): self
    {
        $this->expression = $expression;

        return $this;
    }

    protected static function attributesMetadata(): array
    {
        return array (
          'parent' =>
          array (
            'type' =>
            array (
              0 => 'Transfer\\Simple\\SimpleObjectTransfer',
              1 => 'null',
            ),
            'required' => false,
            'actionName' => 'parent',
          ),
          'username' =>
          array (
            'type' =>
            array (
              0 => 'string',
              1 => 'null',
            ),
            'required' => false,
            'actionName' => 'username',
          ),
          'age' =>
          array (
            'type' =>
            array (
              0 => 'int',
              1 => 'null',
            ),
            'required' => false,
            'actionName' => 'age',
          ),
          'email' =>
          array (
            'type' =>
            array (
              0 => 'string',
              1 => 'null',
            ),
            'required' => false,
            'actionName' => 'email',
          ),
          'ip' =>
          array (
            'type' =>
            array (
              0 => 'string',
              1 => 'null',
            ),
            'required' => false,
            'actionName' => 'ip',
          ),
          'hostname' =>
          array (
            'type' =>
            array (
              0 => 'string',
              1 => 'null',
            ),
            'required' => false,
            'actionName' => 'hostname',
          ),
          'sometext' =>
          array (
            'type' =>
            array (
              0 => 'string',
              1 => 'null',
            ),
            'required' => false,
            'actionName' => 'sometext',
          ),
          'url' =>
          array (
            'type' =>
            array (
              0 => 'string',
              1 => 'null',
            ),
            'required' => false,
            'actionName' => 'url',
          ),
          'json' =>
          array (
            'type' =>
            array (
              0 => 'string',
              1 => 'null',
            ),
            'required' => false,
            'actionName' => 'json',
          ),
          'uuid' =>
          array (
            'type' =>
            array (
              0 => 'string',
              1 => 'null',
            ),
            'required' => false,
            'actionName' => 'uuid',
          ),
          'created_at' =>
          array (
            'type' =>
            array (
              0 => 'string',
              1 => 'null',
            ),
            'required' => false,
            'actionName' => 'createdAt',
          ),
          'updated_at' =>
          array (
            'type' =>
            array (
              0 => 'string',
              1 => 'null',
            ),
            'required' => false,
            'actionName' => 'updatedAt',
          ),
          'timezone' =>
          array (
            'type' =>
            array (
              0 => 'string',
              1 => 'null',
            ),
            'required' => false,
            'actionName' => 'timezone',
          ),
          'card_scheme' =>
          array (
            'type' =>
            array (
              0 => 'string',
              1 => 'null',
            ),
            'required' => false,
            'actionName' => 'cardScheme',
          ),
          'bic' =>
          array (
            'type' =>
            array (
              0 => 'string',
              1 => 'null',
            ),
            'required' => false,
            'actionName' => 'bic',
          ),
          'currency' =>
          array (
            'type' =>
            array (
              0 => 'string',
              1 => 'null',
            ),
            'required' => false,
            'actionName' => 'currency',
          ),
          'iban' =>
          array (
            'type' =>
            array (
              0 => 'string',
              1 => 'null',
            ),
            'required' => false,
            'actionName' => 'iban',
          ),
          'isbn' =>
          array (
            'type' =>
            array (
              0 => 'string',
              1 => 'null',
            ),
            'required' => false,
            'actionName' => 'isbn',
          ),
          'issn' =>
          array (
            'type' =>
            array (
              0 => 'string',
              1 => 'null',
            ),
            'required' => false,
            'actionName' => 'issn',
          ),
          'isin' =>
          array (
            'type' =>
            array (
              0 => 'string',
              1 => 'null',
            ),
            'required' => false,
            'actionName' => 'isin',
          ),
          'choice' =>
          array (
            'type' =>
            array (
              0 => 'string',
              1 => 'int',
              2 => 'float',
              3 => 'array',
              4 => 'null',
            ),
            'required' => false,
            'actionName' => 'choice',
          ),
          'expression' =>
          array (
            'type' =>
            array (
              0 => 'string',
              1 => 'int',
              2 => 'null',
            ),
            'required' => false,
            'actionName' => 'expression',
          ),
        );
    }
}
