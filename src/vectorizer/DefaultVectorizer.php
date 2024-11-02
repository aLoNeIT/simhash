<?php

declare(strict_types=1);

namespace alonetech\simhash\vectorizer;

class DefaultVectorizer implements VectorizerInterface
{
    /** @inheritDoc */
    public function vectorize(array $tokens, int $size): array
    {
        // 创建带有权重值的令牌数组
        $weightTokens = $this->createWeightTokens($tokens);
        $vector = \array_fill(0, $size, 0);
        // 合并处理，最终变成一个长度为$size大小的数组，每个元素是所有令牌计算之后的结果
        foreach ($weightTokens as $token => $weight) {
            for ($i = 0; $i < $size; $i++) {
                if ($token[$i] === '1') {
                    $vector[$i] += (int) $weight;
                } else {
                    $vector[$i] -= (int) $weight;
                }
            }
        }
        return $vector;
    }
    /**
     * 创建带有权重值的令牌数组
     *
     * @param array $tokens 令牌数组
     * @return array 返回带有权重值的令牌数组
     */
    protected function createWeightTokens(array $tokens): array
    {
        // 进行权重计算
        $weightTokens = [];
        foreach ($tokens as $token) {
            if (! isset($weightTokens[$token])) {
                $weightTokens[$token] = VectorizerInterface::WEIGHT_VALUE;
            } else {
                $weightTokens[$token] += VectorizerInterface::WEIGHT_VALUE;
            }
        }
        return $weightTokens;
    }
}
