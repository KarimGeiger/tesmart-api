<?php

namespace TesmartApi;

use InvalidArgumentException;
use TesmartApi\Exception\ConnectionException;

class Client
{
    public function __construct(private $ip = '192.168.1.10', private $port = 5000, private $timeout = 60)
    {
    }

    /**
     * Get the currently selected input port.
     *
     * @return int 1 = PC1, 2 = PC2, ..., 16 = PC16
     * @throws ConnectionException
     */
    public function getInput(): int
    {
        $response = $this->sendCommand(0x10);

        return hexdec($response['o2']) + 1;
    }

    /**
     * Set the KVM switch to the given input.
     *
     * @param int $input 1 = PC1, 2 = PC2, ..., 16 = PC16
     * @throws InvalidArgumentException
     * @throws ConnectionException
     */
    public function setInput(int $input): void
    {
        if ($input < 1 || $input > 0xFF) {
            throw new InvalidArgumentException('Invalid range for input.');
        }
        $this->sendCommand(0x01, $input);
    }

    /**
     * Enable or disable the buzzer.
     *
     * @throws ConnectionException
     */
    public function setBuzzer(bool $enabled): void
    {
        $this->sendCommand(0x02, $enabled ? 0x01 : 0x00);
    }

    /**
     * Set the LED timeout.
     *
     * @param int $seconds timeout in seconds. 0 = never
     * @throws InvalidArgumentException
     * @throws ConnectionException
     */
    public function setLedTimeout(int $seconds): void
    {
        if ($seconds < 0 || $seconds > 0xFF) {
            throw new InvalidArgumentException('Invalid range for seconds.');
        }
        $this->sendCommand(0x03, $seconds);
    }

    /**
     * Send command to switch and get binary output.
     *
     * @throws ConnectionException
     */
    private function sendCommand(int $command, int $param = 0x00): array
    {
        // Open connection
        $fp = fsockopen('tcp://' . $this->ip, $this->port, $error_code, $error_message, $this->timeout);
        stream_set_blocking($fp, 0);
        if (!$fp) {
            throw new ConnectionException($error_message, $error_code);
        }

        // send command
        $data = pack('c6', 0xAA, 0xBB, 0x03, $command, $param, 0xEE);
        fwrite($fp, $data);

        // wait and fetch response
        usleep(2000);
        while (!$out = fread($fp, 6)) {
            usleep(1000);
        }

        // unpack, close connection and return result
        $out = unpack('H6b/H2o1/H2o2/H2e', $out);
        fclose($fp);

        return $out;
    }
}