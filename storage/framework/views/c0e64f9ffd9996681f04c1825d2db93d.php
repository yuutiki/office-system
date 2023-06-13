    
<link rel="shortcut icon" href="<?php echo e(asset('/favicon-sales.ico')); ?>">

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
        預託情報の編集画面
    </h2>

    <div class="flex flex-row-reverse">
        <?php if (isset($component)) { $__componentOriginal71c6471fa76ce19017edc287b6f4508c = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.general-button','data' => ['class' => 'mt-4','onclick' => 'location.href=\''.e(route('keepfile.index', $keepfile)).'\'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('general-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-4','onclick' => 'location.href=\''.e(route('keepfile.index', $keepfile)).'\'']); ?>
            戻る
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal71c6471fa76ce19017edc287b6f4508c)): ?>
<?php $component = $__componentOriginal71c6471fa76ce19017edc287b6f4508c; ?>
<?php unset($__componentOriginal71c6471fa76ce19017edc287b6f4508c); ?>
<?php endif; ?>
    </div>


    


    <div>  
        <?php if($errors->any()): ?>  
            <ul>  
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>  
                    <li class="text-red-600"><?php echo e($error); ?></li>  
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
            </ul>  
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
    <form method="post" action="<?php echo e(route('keepfile.update',$keepfile)); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('patch'); ?>


        <label class="relative inline-flex items-center cursor-pointer">
        <input type="hidden" name="is_finished" id="is_finished" value="0">
        <?php if($keepfile->is_finished === 1): ?>
            <input type="checkbox" name="is_finished" id="is_finished" value="1" class="sr-only peer" checked="checked">
        <?php else: ?>
            <input type="checkbox" name="is_finished" id="is_finished" value="1" class="sr-only peer">
        <?php endif; ?>
            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
            <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">完了</span>
        </label>
        <span class="ml-10 text-sm font-medium text-gray-900 dark:text-gray-300">返却時は「  sdg-sales-ismstensou@systemd.co.jp  」をCcに含めてメールしてください</span>
       


        <div class="md:flex items-center mt-8">
            <div class="w-full flex flex-col">
                <label for="project_num" class="font-semibold text-gray-100 leading-none mt-4">プロジェクト№</label>
                <input type="text" name="project_num" class="w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="project_num" value="<?php echo e(old('project_num',$keepfile->project_num)); ?>" placeholder="例）9999000100">
            </div>
        </div>

        <div class="w-full flex flex-col">
            <label for="clientname" class="font-semibold text-gray-100 leading-none mt-4">客先名</label>
            <input type="text" name="clientname" class="w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="clientname" value="<?php echo e(old('clientname',$keepfile->clientname)); ?>" placeholder="例）学校法人  〇〇大学">
        </div>

        <div class="w-full flex flex-col">
            <label for="purpose" class="font-semibold text-gray-100 leading-none mt-4">用途</label>
            <input type="text" name="purpose" class="w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="purpose" value="<?php echo e(old('purpose',$keepfile->purpose)); ?>" placeholder="例）バージョンアップ">
        </div>

        <div class="w-full flex flex-col">
            <label for="keep_at" class="font-semibold text-gray-100 leading-none mt-4">預託日</label>
            <input type="date" min="2000-01-01" max="2100-12-31" name="keep_at" class="w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="keep_at" value="<?php echo e(old('keep_at',$keepfile->keep_at)); ?>">
        </div>

        <div class="w-full flex flex-col">
            <label for="return_at" class="font-semibold text-gray-100 leading-none mt-4">返却日</label>
            <input type="date" min="2000-01-01" max="2100-12-31" name="return_at" class="w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" id="return_at" value="<?php echo e(old('return_at',$keepfile->return_at)); ?>">
        </div>

        
        <div class="w-full flex flex-col">
            <label for="memo" class="font-semibold text-gray-100 leading-none mt-4">備考</label>
            <textarea name="memo" class="w-auto py-2 border border-gray-300 rounded-md mt-1 placeholder-gray-500" id="memo"  cols="30" rows="10" placeholder="例）預託期限が来たため延長しました。"><?php echo e(old('memo',$keepfile->memo)); ?></textarea>
        </div>

        

        

        <?php if (isset($component)) { $__componentOriginal71c6471fa76ce19017edc287b6f4508c = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.primary-button','data' => ['class' => 'mt-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('primary-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-4']); ?>
            変更を確定
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal71c6471fa76ce19017edc287b6f4508c)): ?>
<?php $component = $__componentOriginal71c6471fa76ce19017edc287b6f4508c; ?>
<?php unset($__componentOriginal71c6471fa76ce19017edc287b6f4508c); ?>
<?php endif; ?>
        
    </form>
</div>
</div>


 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\laravel\officesystem\resources\views/keepfile/edit.blade.php ENDPATH**/ ?>