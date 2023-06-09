<?php
/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace Sonata\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Translation\TranslatorInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EqualType extends AbstractType
{
    const TYPE_IS_EQUAL = 1;

    const TYPE_IS_NOT_EQUAL = 2;

    protected $translator;

    /**
     * @param \Symfony\Component\Translation\TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => array(
                self::TYPE_IS_EQUAL     => $this->translator->trans('label_type_equals', array(), 'SonataCoreBundle'),
                self::TYPE_IS_NOT_EQUAL => $this->translator->trans('label_type_not_equals', array(), 'SonataCoreBundle'),
            )
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function getParent()
    {
        return 'choice';
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'sonata_type_equal';
    }
}
