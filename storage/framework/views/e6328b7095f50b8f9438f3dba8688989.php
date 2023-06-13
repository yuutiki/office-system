<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            預託情報の個別表示
        </h2>

        <div tubindex="0" class="flex flex-row-reverse">
            <?php if (isset($component)) { $__componentOriginal71c6471fa76ce19017edc287b6f4508c = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.general-button','data' => ['class' => 'mt-4','onclick' => 'location.href=\''.e(route('keepfile.index', $keepfile)).'\'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('general-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-4','onclick' => 'location.href=\''.e(route('keepfile.index', $keepfile)).'\'']); ?>
                一覧へ
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal71c6471fa76ce19017edc287b6f4508c)): ?>
<?php $component = $__componentOriginal71c6471fa76ce19017edc287b6f4508c; ?>
<?php unset($__componentOriginal71c6471fa76ce19017edc287b6f4508c); ?>
<?php endif; ?>


        </div>


        <?php if (isset($component)) { $__componentOriginal71c6471fa76ce19017edc287b6f4508c = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.message','data' => ['message' => session('message')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('message'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['message' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(session('message'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal71c6471fa76ce19017edc287b6f4508c)): ?>
<?php $component = $__componentOriginal71c6471fa76ce19017edc287b6f4508c; ?>
<?php unset($__componentOriginal71c6471fa76ce19017edc287b6f4508c); ?>
<?php endif; ?>

     <?php $__env->endSlot(); ?>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mx-4 sm:p-8">
            <div class="px-10 mt-4">

                <div class="bg-white w-full  rounded-2xl px-10 py-8 shadow-lg hover:shadow-2xl transition duration-500">
                    <div class="mt-4">
                        <h1 class="text-lg text-gray-700 font-semibold">
                            <?php echo e($keepfile->projectnumber); ?>

                            
                            
                        </h1>
                        <hr class="w-full">
                        <div class="mt-4 text-gtay-600 font-semibold">ステータス</div>
                        <?php if($keepfile->status_flag == "0"): ?>
                        <p class="ml-4 text-gray-600 py-1 whitespace-pre-line">未返却</p>
                        <?php else: ?>
                        <p class="ml-4 text-gray-600 py-1 whitespace-pre-line">返却済</p>
                        <?php endif; ?>
                        <div class="mt-4 text-gtay-600 font-semibold">顧客名</div>
                        <p class="ml-4 text-gray-600 py-1 whitespace-pre-line"><?php echo e($keepfile->clientname); ?></p>
                        <div class="mt-4 text-gtay-600 font-semibold">用途</div>
                        <p class="ml-4 text-gray-600 py-1 whitespace-pre-line"><?php echo e($keepfile->purpose); ?></p>
                        <div class="mt-4 text-gtay-600 font-semibold">預託日</div>
                        <p class="ml-4 text-gray-600 py-1 whitespace-pre-line"><?php echo e($keepfile->keepdate); ?></p>
                        <div class="mt-4 text-gtay-600 font-semibold">返却日</div>
                        <p class="ml-4 text-gray-600 py-1 whitespace-pre-line"><?php echo e($keepfile->returndate); ?></p>
                        <div class="mt-4 text-gtay-600 font-semibold">備考</div>
                        <p class="ml-4 text-gray-600 py-1 whitespace-pre-line"><?php echo e($keepfile->memo); ?></p>
                        <div class="text-sm font-semibold flex flex-row-reverse">
                            <p> <?php echo e($keepfile->user->name); ?> • <?php echo e($keepfile->created_at->diffForHumans()); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\laravel\officesystem\resources\views/keepfile/show.blade.php ENDPATH**/ ?>