<?php

declare(strict_types=1);

namespace alonetech\simhash\extractor;

use Fukuball\Jieba\Finalseg;
use Fukuball\Jieba\Jieba;

/**
 * 基于Jieba分词器的文本特征提取器  
 * cut方法选项支持cut_all、jieba_cut_options参数
 *   - ignore_blank：是否忽略空白字符
 *   - cut_all：是否全模式
 *   - jieba_cut_options：jieba分词cut函数的options参数，默认为['HMM' => true]
 * 
 * @author aLoNe.Adams.K <alone@alonetech.com>
 */
class JieBaExtractor implements ExtractorInterface
{
    /**
     * 是否已初始化
     */
    static $inited = false;
    /**
     * 构造函数
     */
    public function __construct()
    {
        // 初始化
        if (!static::$inited) {
            Jieba::init();
            Finalseg::init();
            static::$inited = true;
        }
    }

    /** @inheritDoc */
    public function extract(string $content, array $options = []): array
    {
        $punctuation = $options['punctuation'] ?? ExtractorInterface::PUNCTUATION;
        $content = \str_replace($punctuation, '', $content);
        $words = Jieba::cut($content, $options['cut_all'] ?? false, $options['jieba_cut_options'] ?? [
            'HMM' => true
        ]);
        if (isset($options['ignore_blank']) && true == $options['ignore_blank']) {
            // 设置了忽略空白字符选项，则过滤空白字符
            $words = \array_filter($words, function ($word) {
                return '' != \trim($word);
            });
        }
        return $words;
    }
}
