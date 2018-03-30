<?php

namespace Api\Observer;

use Framework\EventManager\Observer;
use Api\Service\CommentServiceInterface;

class CommentObserver extends Observer
{
    /**
     * @var array
     */
    private $emotions = [
        ':-)))' => '<img src="/img/emoticons/happy.png" />',
        ')))' => '<img src="/img/emoticons/happy.png" />',
        ':-))' => '<img src="/img/emoticons/happy.png" />',
        ':))' => '<img src="/img/emoticons/happy.png" />',
        '))' => '<img src="/img/emoticons/happy.png" />',

        ':-|' => '<img src="/img/emoticons/confused.png" />',
        ':|' => '<img src="/img/emoticons/confused.png" />',

        '(((' => '<img src="/img/emoticons/sad.png" />',
        ':-(' => '<img src="/img/emoticons/sad.png" />',
        ':(' => '<img src="/img/emoticons/sad.png" />',
        ':((' => '<img src="/img/emoticons/sad.png" />',
        '((' => '<img src="/img/emoticons/sad.png" />',

        ':-)' => '<img src="/img/emoticons/smiling.png" />',
        ':)' => '<img src="/img/emoticons/smiling.png" />',

        ';-)' => '<img src="/img/emoticons/wink.png" />',
        ';)' => '<img src="/img/emoticons/wink.png" />',
    ];

    /**
     * @param array $formData
     * 
     * @throws \Framework\Instantiator\InstantiatorException
     *
     * @return bool
     */
    public function onSubmit($formData)
    {
        $content = $formData['content'];
        foreach ($this->emotions as $template => $replacement) {
            $content = str_replace($template, $replacement, $content);
        }
        $formData['content_changed'] = $content;
        $commentService = $this->instantiator->instantiate(CommentServiceInterface::class);
        $commentService->store($formData);
        return $formData;
    }
}