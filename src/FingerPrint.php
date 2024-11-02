<?php

declare(strict_types=1);

namespace alonetech\simhash;

class FingerPrint
{
    /**
     * 指纹每个数据的长度
     *
     * @var integer
     */
    protected int $size = 32;
    /**
     * 当前指纹hash值
     *
     * @var string
     */
    protected string $hash = '';
    /**
     * 指纹数据，每个元素都是一个整型
     *
     * @var int[]
     */
    protected array $data = [];
    /**
     * 构造函数
     *
     * @param integer $size 指纹数据中，每个数据的长度，建议不超过操作系统中的整型长度
     */
    public function __construct(int $size = PHP_INT_SIZE * 4)
    {
        $this->size = $size;
    }
    /**
     * 指纹hash值，十六进制字符串
     *
     * @param string $hash 指纹hash值
     * @return static 返回当前指纹对象
     */
    public function load(string $hash): static
    {
        // 计算hash对应的二进制字符串长度，十六进制2位为一字节
        $length = \strlen($hash);
        $block = $this->size / 8 * 2;
        if (0 !== ($length / 2 * 8) % $this->size) {
            // 不是整数倍，则抛出异常
            throw new \InvalidArgumentException('输入的哈希字符串长度不是当前指纹支持的整数倍');
        }
        $data = [];
        for ($i = 0; $i < ($length / $block); $i++) {
            $hexBlock = \substr($hash, $i * $block, $block);
            // 将每两位转成二进制字符串
            $binary = '';
            for ($j = 0; $j < \strlen($hexBlock); $j += 2) {
                $hex = \substr($hexBlock, $j, 2);
                $binary .= \str_pad(\decbin(\hexdec($hex)), 8, '0', STR_PAD_LEFT);
            }
            // 将二进制字符串转换为整数
            $data[] = \bindec($binary);
        }
        $this->data = $data;
        $this->hash = $hash;
        // 二进制字符串进行拆分
        return $this;
    }
    /**
     * 加载指纹二进制字符串
     *
     * @param string $binary 指纹二进制字符串
     * @return static 返回当前指纹对象
     */
    public function loadBinary(string $binary): static
    {
        // 获取二进制字符串长度
        $len = \strlen($binary);
        if (0 !== $len % $this->size) {
            // 不是整数倍，则抛出异常
            throw new \InvalidArgumentException('输入的二进制字符串长度不是当前指纹支持的整数倍');
        }
        // 循环处理，将二进制字符串转成多个整数存储
        $block = $len / $this->size;
        $data = [];
        $hash = '';
        for ($i = 0; $i < $block; $i++) {
            $binStr = \substr($binary, $i * $this->size, $this->size);
            $data[] = \bindec($binStr);
            // 每8位转成十进制，再转十六进制
            for ($j = 0; $j < \strlen($binStr) / 8; $j++) {
                $hex = \dechex(\bindec(\substr($binStr, $j * 8, 8)));
                $hash .= \str_pad($hex, 2, '0', STR_PAD_LEFT);
            }
        }
        $this->data = $data;
        $this->hash = $hash;
        return $this;
    }
    /**
     * 加载指纹数据
     *
     * @param array $data 指纹数据
     * @return static 返回当前指纹对象
     */
    public function loadData(array $data): static
    {
        $hash = '';
        foreach ($data as $item) {
            // 每个数据转换为二进制字符串
            $binary = \str_pad(\decbin($item), $this->size, '0', STR_PAD_LEFT);
            // 每8位转成十六进制
            for ($i = 0; $i < \strlen($binary) / 8; $i++) {
                $hex = \dechex(\bindec(\substr($binary, $i * 8, 8)));
                $hash .= \str_pad($hex, 2, '0', STR_PAD_LEFT);
            }
        }
        // 获取二进制字符串长度
        $length = \strlen($hash);
        if (0 !== ($length / 2 * 8) % $this->size) {
            // 不是整数倍，则抛出异常
            throw new \InvalidArgumentException('当前指纹数据不正确');
        }
        $this->data = $data;
        $this->hash = $hash;
        return $this;
    }
    /**
     * 获取指纹字符串数据
     *
     * @return string
     */
    public function __toString()
    {
        return $this->hash;
    }
    /**
     * 获取指纹数据
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
    /**
     * 获取指纹数据数量
     *
     * @return integer
     */
    public function getDataCount(): int
    {
        return \count($this->data);
    }
    /**
     * 获取指纹数据大小
     *
     * @return integer
     */
    public function getDataSize(): int
    {
        return $this->size * \count($this->data);
    }
    /**
     * 获取指纹二进制字符串
     *
     * @return string
     */
    public function getBinary(): string
    {
        $binary = '';
        foreach ($this->data as $item) {
            $binary .= \decbin($item);
        }
        return $binary;
    }
}
