<?php

namespace Model\Entity;


interface CommentInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getUserName();

    /**
     * @param string $userName
     *
     * @return CommentInterface
     */
    public function setUserName($userName);

    /**
     * @return string
     */
    public function getContent();

    /**
     * @param string $content
     * @return CommentInterface
     */
    public function setContent($content);

    /**
     * @return string
     */
    public function getContentChanged();

    /**
     * @param string $contentChanged
     * @return CommentInterface
     */
    public function setContentChanged($contentChanged);

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @param \DateTime $createdAt
     * @return CommentInterface
     */
    public function setCreatedAt($createdAt);

    /**
     * @return \DateTime
     */
    public function getUpdatedAt();

    /**
     * @param \DateTime $updatedAt
     * @return CommentInterface
     */
    public function setUpdatedAt($updatedAt);
}