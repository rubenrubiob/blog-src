<?php

declare(strict_types=1);

namespace rubenrubiob\Infrastructure\Symfony\DependencyInjection;

use CuyZ\Valinor\Mapper\TreeMapper;
use CuyZ\Valinor\MapperBuilder;
use Generator;
use League\ConstructFinder\ConstructFinder;
use ReflectionClass;
use ReflectionException;
use rubenrubiob\Domain\ValueObject\ValueObject;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

use function sprintf;
use function Safe\preg_match;

final readonly class ValinorMapperRegisterConstructorCompilerPass implements CompilerPassInterface
{
    private const VO_NAMESPACE_PATTERN = '/Domain\\\\ValueObject(\\\\(.*))?/i';
    private const SRC_FOLDER_MASK = '%s/src';

    public function __construct(
        private string $projectDir,
    ) {
    }

    /**
     * @throws ReflectionException
     */
    public function process(ContainerBuilder $container): void
    {
        $container->setDefinition(
            TreeMapper::class,
            $this->mapperDefinition(
                $this->mapperBuilderDefinition()
            )
        );
    }

    private function mapperDefinition(Definition $mapperBuilderDefinition): Definition
    {
        $mapperDefinition = new Definition(TreeMapper::class);

        $mapperDefinition->setFactory(
            [
                $mapperBuilderDefinition,
                'mapper'
            ]
        );

        return $mapperDefinition;
    }

    /**
     * @throws ReflectionException
     */
    private function mapperBuilderDefinition(): Definition
    {
        $mapperBuilderDefinition = new Definition(MapperBuilder::class);
        $valueObjectsWithNamedConstructor = $this->valueObjectsWithNamedConstructor();

        foreach ($valueObjectsWithNamedConstructor as $valueObjectConstructor) {
            $mapperBuilderDefinition->addMethodCall(
                'registerConstructor',
                [$valueObjectConstructor->getMethod('defaultNamedConstructor')->invoke(null)],
                true,
            );
        }

        $mapperBuilderDefinition->addMethodCall(
            'enableFlexibleCasting',
            [],
            true
        );

        $mapperBuilderDefinition->addMethodCall(
            'allowSuperfluousKeys',
            [],
            true
        );

        return $mapperBuilderDefinition;
    }

    /**
     * @return Generator<mixed, ReflectionClass<ValueObject>>
     */
    private function valueObjectsWithNamedConstructor(): iterable
    {
        $srcFolder = sprintf(self::SRC_FOLDER_MASK, $this->projectDir);

        $classNames = ConstructFinder::locatedIn($srcFolder)->findClassNames();

        foreach ($classNames as $className) {
            if (preg_match(self::VO_NAMESPACE_PATTERN, $className) === 0) {
                continue;
            }

            $reflection = new ReflectionClass($className);

            if ($reflection->isInterface()) {
                continue;
            }

            if (!$reflection->implementsInterface(ValueObject::class)) {
                continue;
            }

            yield $reflection;
        }
    }
}
