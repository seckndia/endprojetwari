<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerMaMbsbA\srcApp_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerMaMbsbA/srcApp_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerMaMbsbA.legacy');

    return;
}

if (!\class_exists(srcApp_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerMaMbsbA\srcApp_KernelDevDebugContainer::class, srcApp_KernelDevDebugContainer::class, false);
}

return new \ContainerMaMbsbA\srcApp_KernelDevDebugContainer([
    'container.build_hash' => 'MaMbsbA',
    'container.build_id' => '429b188c',
    'container.build_time' => 1566287718,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerMaMbsbA');
