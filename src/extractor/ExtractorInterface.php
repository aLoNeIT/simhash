<?php

declare(strict_types=1);

namespace alonetech\simhash\extractor;

/**
 * 分词器接口
 * 
 * @author aLoNe.Adams.K <alone@alonetech.com>
 */
interface ExtractorInterface
{
    /**
     * 标点符号
     */
    const PUNCTUATION = [
        '，',
        '。',
        '：',
        '；',
        '！',
        '“',
        '”',
        '‘',
        '’',
        '、',
        "\t",
        '（',
        '）',
        '.',
        ',',
        ';',
        ':',
        '!',
        '?',
        '"',
        "'",
        '(',
        ')',
        '[',
        ']',
        '{',
        '}',
        '<',
        '>',
        '-',
        '_',
        '*',
        '&',
        '^',
        '%',
        '$',
        '#',
        '@',
        '!',
        '~',
        '`',
        '|',
        '\\',
        '/',
        '+',
        '='
    ];
    /**
     * 提取文本的特征，返回分词后的数组
     *
     * @param string $content 原始文本内容
     * @param array $options 分词选项，不同分词器支持不同参数
     * @return string[] 返回分词后的数组
     */
    public function extract(string $content, array $options = []): array;
}
