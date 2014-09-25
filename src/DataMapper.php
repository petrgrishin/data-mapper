<?php
/**
 * @author Petr Grishin <petr.grishin@grishini.ru>
 */
namespace PetrGrishin\DataMapper;


class DataMapper {
    /** Получить данные с ключами источника */
    const SOURCE = 1;
    /** Получить данные с ключами по карте маппинга */
    const DESTINATION = 2;
    /** @var array Карта */
    private $map;
    /** @var array Данные источника */
    private $data;
    /** @var array Данные после применения карты маппинга */
    private $dataDestination;

    /**
     * @param array $map
     * @throws \Exception
     */
    public function __construct(array $map) {
        if (empty($map)) {
            throw new \Exception("Map is empty");
        }
        $this->map = $map;
    }

    /**
     * Устанавливает данные источника
     * @param array $data
     * @return $this
     */
    public function setData(array $data) {
        $this->data = $data;
        return $this;
    }

    /**
     * Получить данные, по-умолчанию с ключами по карте маппинга
     * @param int $keys
     * @return array
     * @throws \Exception
     */
    public function getData($keys = self::DESTINATION) {
        if ($keys == self::DESTINATION) {
            // TODO: магия, нужно рефакторить :)
            $this->dataMapping($this->map, $this->data);
            return $this->dataDestination;

        } elseif ($keys == self::SOURCE) {
            return $this->data;
        }
        throw new \Exception("Incorrect keys format");
    }

    /**
     * Применяет карту маппинга к данным, и сохраняет их в $this->dataDestination
     * @param array $map
     * @param array $data
     * @param bool $skipNonExistingKey
     * @return bool
     * @throws \Exception
     */
    private function dataMapping(array $map, array $data, $skipNonExistingKey = true) {
        foreach ($map ? : array() as $key => $destinationKey) {
            if ($destinationKey === null) {
                continue;
            }
            if (!array_key_exists($key, $data)) {
                if ($skipNonExistingKey) {
                    continue;
                } else {
                    throw new \Exception("Incorrect key '{$key}' in source data");
                }
            }
            if (is_array($destinationKey)) {
                if (!is_array($data[$key])) {
                    continue;
                }
                $this->dataMapping($destinationKey, $data[$key]);
            } else {
                $this->dataDestination[$destinationKey] = $data[$key];
            }
        }
    }
}
