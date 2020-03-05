<?php
/**
 * @package Extra_QuestionnaireBundle
 * @author  Lubo Grozdanov <grozdanov.lubo@gmail.com>
 */

namespace Extra\QuestionnaireBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use A2lix\I18nDoctrineBundle\Doctrine\ORM\Util\Translation;
use A2lix\I18nDoctrineBundle\Doctrine\Interfaces\OneLocaleInterface;
use ThirdPartyBundle\TranslationsBundle\Entity\TranslatableManyToOneInterface;


/**
 *
 * @ORM\Entity(repositoryClass="Extra\QuestionnaireBundle\Repository\QuestionnaireTranslationRepository")
 * @ORM\Table(
 *     name="questionnaires_i18n",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="lookup_unique_idx",
 *     columns={
 *     "locale", "object_id"
 *   })
 * })
 */
class QuestionnaireTranslation  implements OneLocaleInterface,
                                          TranslatableManyToOneInterface
{
    use Translation,
        Timestampable;

    /**
     * @ORM\ManyToOne(targetEntity="\Extra\QuestionnaireBundle\Entity\Questionnaire", inversedBy="translations")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $translatable;

    /**
     * @ORM\Column(length=1024, nullable=false)
     */
    protected $title;

    public function __toString()
    {
      return $this->title ?? '';
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
}
