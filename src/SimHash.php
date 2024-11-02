<?php

declare(strict_types=1);

namespace alonetech\simhash;

use alonetech\simhash\extractor\ExtractorInterface;
use alonetech\simhash\extractor\JieBaExtractor;
use alonetech\simhash\tokenizer\String128Tokenizer;
use alonetech\simhash\tokenizer\TokenizerInterface;
use alonetech\simhash\vectorizer\DefaultVectorizer;
use alonetech\simhash\vectorizer\VectorizerInterface;

class SimHash
{
    /**
     * 分词器
     *
     * @var ExtractorInterface
     */
    protected ExtractorInterface $extractor;
    /**
     * 向量处理器
     *
     * @var VectorizerInterface
     */
    protected VectorizerInterface $vectorizer;

    /**
     * 令牌处理器
     *
     * @var TokenizerInterface
     */
    protected TokenizerInterface $tokenizer;
    /**
     * 构造函数
     *
     * @param ExtractorInterface|null $extractor 分词对象
     * @param TokenizerInterface|null $tokenizer 令牌对象
     * @param VectorizerInterface|null $vectorizer 向量对象
     */
    public function __construct(
        ExtractorInterface $extractor = null,
        TokenizerInterface $tokenizer = null,
        VectorizerInterface $vectorizer = null
    ) {
        $this->extractor = $extractor ?: new JieBaExtractor();
        $this->tokenizer = $tokenizer ?: new String128Tokenizer();
        $this->vectorizer = $vectorizer ?: new DefaultVectorizer();
    }
    /**
     * 进行哈希计算，生成指纹对象
     *
     * @param string $content 文本内容
     * @return FingerPrint 返回指纹对象
     */
    public function hash(string $content): FingerPrint
    {
        // 分词
        $words = $this->extractor->extract($content);
        // 令牌化
        $tokens = [];
        foreach ($words as $word) {
            $tokens[] = $this->tokenizer->tokenize($word);
        }
        // 向量计算
        $vector = $this->vectorizer->vectorize($tokens, $this->tokenizer->supportSize());
        $fpData = \array_fill(0, $this->tokenizer->supportSize(), 0);
        for ($i = 0; $i < $this->tokenizer->supportSize(); $i++) {
            if ($vector[$i] > 0) {
                $fpData[$i] = 1;
            }
        }
        // 生成指纹
        return (new FingerPrint())->loadBinary(\implode('', $fpData));
    }
}
