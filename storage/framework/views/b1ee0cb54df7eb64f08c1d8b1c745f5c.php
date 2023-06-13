    
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
            ユーザ一覧（管理者機能）
        </h2>
        
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

    <div id="app" class="p-5">
        <!-- 一覧表示するブロック ① -->
        <div v-if="state=='index'">

            
            <div class="mb-3 text-right mr-32 mt-24">
                <?php if (isset($component)) { $__componentOriginal71c6471fa76ce19017edc287b6f4508c = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.primary-button','data' => ['class' => 'mt-4','@click' => 'changeState(\'create\')']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('primary-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-4','@click' => 'changeState(\'create\')']); ?>
                    ユーザ追加
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal71c6471fa76ce19017edc287b6f4508c)): ?>
<?php $component = $__componentOriginal71c6471fa76ce19017edc287b6f4508c; ?>
<?php unset($__componentOriginal71c6471fa76ce19017edc287b6f4508c); ?>
<?php endif; ?>
            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg ml-32 mr-32 ">

                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 ">
                    <thead class="text-sm text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-100">
                        <tr>
                            <th scope="col" class="px-4 py-3">
                                <div class="flex items-center">
                                    <?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('name','氏名'));?>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg>
                                </div>
                            </th>
                            <th scope="col" class="px-1 py-3">
                                <div class="flex items-center">
                                    <?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('email','E-Mail'));?>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                                </div>
                            </th>
                            <th scope="col" class="px-2 py-3">
                                <div class="flex items-center">
                                    作成日
                                    
                                </div>
                            </th>
                            <th scope="col" class="px-2 py-3">
                                <div class="flex items-center">
                                    権限
                                    
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <span class="sr-only">編集</span>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <span class="sr-only">顧客追加</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in users" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-600 dark:text-white">
                            <td v-text="user.name" class="px-2 py-4"></td>
                            <td v-text="user.email" class="px-2 py-4"></td>
                            <td v-text="user.email" class="px-2 py-4"></td>
                            <td v-text="user.role_id" class="px-2 py-4"></td>
                            <td class="text-left px-2 py-4">
                                <button class="" type="button" @click="changeState('edit', user)">変更</button>
                            </td>
                            <td class="text-left px-2 py-4">
                                <button class="text-red-500" type="button" @click="onDelete(user)">削除</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- ページ移動のリンク ③ -->
                <?php echo e($users->links()); ?>

        </div>
    </div>

        <!-- 追加＆変更するブロック ② -->
        <div v-if="state=='create' || state == 'edit'">

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="mb-3 text-right">
                    <?php if (isset($component)) { $__componentOriginal71c6471fa76ce19017edc287b6f4508c = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.primary-button','data' => ['class' => 'mt-4 text-right','@click' => 'changeState(\'index\')']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('primary-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-4 text-right','@click' => 'changeState(\'index\')']); ?>
                        戻る
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal71c6471fa76ce19017edc287b6f4508c)): ?>
<?php $component = $__componentOriginal71c6471fa76ce19017edc287b6f4508c; ?>
<?php unset($__componentOriginal71c6471fa76ce19017edc287b6f4508c); ?>
<?php endif; ?>
                </div>

                <div class="md:flex items-center mt-8">
                    <div class="form-group w-full flex flex-col">
                        <label class="font-semibold text-gray-100 leading-none mt-4">名前</label>
                        <input type="text" class="form-control w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" v-model="params.name">
                    </div>
                </div>

                <div class="md:flex items-center mt-8">
                    <div class="w-full flex flex-col">
                        <label class="font-semibold text-gray-100 leading-none mt-4">メールアドレス</label>
                        <input type="text" class=" w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" v-model="params.email">

                    </div>
                </div>

                <div class="md:flex items-center mt-8">
                    <div class="w-full flex flex-col">
                        <label class="font-semibold text-gray-100 leading-none mt-4">権限</label>
                        <select name="role_id" class=" w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" v-model="params.role_id">
                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($role->role_id); ?>"><?php echo e($role->role_name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

                <div class="bg-light px-3 py-2 mb-3 font-semibold text-gray-100" v-if="state == 'edit'">以下は省略可</div>

                <div class="md:flex items-center mt-8">
                    <div class="w-full flex flex-col">
                        <label class="font-semibold text-gray-100 leading-none mt-4">パスワード</label>
                        <input type="password" class="form-control w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" v-model="params.password">
                    </div>
                </div>
                <div class="md:flex items-center mt-8">
                    <div class="w-full flex flex-col">
                        <label class="font-semibold text-gray-100 leading-none mt-4">パスワード（確認）</label>
                        <input type="password" class="form-control w-auto py-2 placeholder-gray-500 border border-gray-300 rounded-md mt-1" v-model="params.passwordConfirmation">
                    </div>
                </div>
                <div class="mb-3 text-right">
                    <?php if (isset($component)) { $__componentOriginal71c6471fa76ce19017edc287b6f4508c = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.primary-button','data' => ['class' => 'mt-4 text-right','@click' => 'onSave']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('primary-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-4 text-right','@click' => 'onSave']); ?>
                        保存する
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal71c6471fa76ce19017edc287b6f4508c)): ?>
<?php $component = $__componentOriginal71c6471fa76ce19017edc287b6f4508c; ?>
<?php unset($__componentOriginal71c6471fa76ce19017edc287b6f4508c); ?>
<?php endif; ?>
                </div>    
            </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>
    <script>

        new Vue({
            el: '#app',
            data: {
                state: 'index',
                params: {
                    id: -1,
                    name: '',
                    email: '',
                    role_id: '',
                    password: '',
                    passwordConfirmation: ''
                },
                users: [
                    // ユーザーデータをJSON化 ④
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $user; ?>,
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                ]
            },
            methods: {
                changeState(state, value) { // 状態を変化させて表示を切り替え ⑤

                    if(state === 'create') {

                        this.params = {
                            id: -1,
                            name: '',
                            email: '',
                            role_id: '',
                            password: '',
                            passwordConfirmation: ''
                        };

                    } else if(state === 'edit') {
                        this.params = value;
                    }

                    this.state = state;

                },
                onSave() { // データ保存（追加＆変更） ⑥

                    const params = this.params;
                    let url = '/user';
                    let method = 'POST';

                    if(this.state === 'edit') { // 変更の場合

                        url += '/'+ this.params.id;
                        method = 'PUT';

                    }

                    axios({ url, method, params })
                        .then(response => {

                            if(response.data.result === true) {

                                location.reload(); // 再読み込み

                            }

                        });

                },
                onDelete(user) { // データ削除 ⑦

                    if(confirm('削除します。よろしいですか？')) {

                        const url = '/user/'+ user.id;
                        axios.delete(url)
                            .then(response => {

                                if(response.data.result === true) {

                                    location.reload(); // 再読み込み

                                }

                            });
                    }
                }
            }
        });
    </script>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\laravel\officesystem\resources\views/admin/user/index.blade.php ENDPATH**/ ?>