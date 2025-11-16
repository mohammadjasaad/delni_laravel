
<?php if (isset($component)) { $__componentOriginal69dc84650370d1d4dc1b42d016d7226b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b = $attributes; } ?>
<?php $component = App\View\Components\GuestLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\GuestLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-b from-gray-50 to-gray-100 px-4">
        <div class="bg-white shadow-2xl rounded-3xl w-full max-w-lg overflow-hidden border border-gray-200">

            
            <div class="text-center py-8 border-b bg-yellow-400">
                <img src="<?php echo e(asset('images/delnilogo.png')); ?>" alt="Delni" class="mx-auto w-24 h-24 mb-2 rounded-full bg-white p-2 shadow">
                <h1 class="text-3xl font-extrabold text-gray-800">مرحبًا بك في Delni.co</h1>
                <p class="text-gray-700 text-sm mt-1">اختر طريقة تسجيل الدخول</p>
            </div>

            
            <div class="flex">
                <button id="tabEmail" class="flex-1 py-3 text-lg font-semibold bg-yellow-400 text-black border-r border-gray-200 focus:outline-none transition">📧 البريد الإلكتروني</button>
                <button id="tabPhone" class="flex-1 py-3 text-lg font-semibold bg-gray-100 text-gray-700 focus:outline-none transition hover:bg-yellow-50">📱 الهاتف / واتساب</button>
            </div>

            <div class="p-8">

                
                <form id="formEmail" method="POST" action="<?php echo e(route('login')); ?>" class="space-y-5">
                    <?php echo csrf_field(); ?>

                    
                    <div class="text-right">
                        <?php if (isset($component)) { $__componentOriginald8ba2b4c22a13c55321e34443c386276 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald8ba2b4c22a13c55321e34443c386276 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.label','data' => ['for' => 'email','value' => 'البريد الإلكتروني','class' => 'text-sm font-semibold text-gray-700']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'email','value' => 'البريد الإلكتروني','class' => 'text-sm font-semibold text-gray-700']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald8ba2b4c22a13c55321e34443c386276)): ?>
<?php $attributes = $__attributesOriginald8ba2b4c22a13c55321e34443c386276; ?>
<?php unset($__attributesOriginald8ba2b4c22a13c55321e34443c386276); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald8ba2b4c22a13c55321e34443c386276)): ?>
<?php $component = $__componentOriginald8ba2b4c22a13c55321e34443c386276; ?>
<?php unset($__componentOriginald8ba2b4c22a13c55321e34443c386276); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input','data' => ['id' => 'email','type' => 'email','name' => 'email','required' => true,'autofocus' => true,'class' => 'mt-1 w-full text-right border-gray-300 rounded-xl focus:ring-yellow-500 focus:border-yellow-500','placeholder' => 'example@email.com']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'email','type' => 'email','name' => 'email','required' => true,'autofocus' => true,'class' => 'mt-1 w-full text-right border-gray-300 rounded-xl focus:ring-yellow-500 focus:border-yellow-500','placeholder' => 'example@email.com']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $attributes = $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $component = $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
                    </div>

                    
                    <div class="text-right">
                        <?php if (isset($component)) { $__componentOriginald8ba2b4c22a13c55321e34443c386276 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald8ba2b4c22a13c55321e34443c386276 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.label','data' => ['for' => 'password','value' => 'كلمة المرور','class' => 'text-sm font-semibold text-gray-700']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'password','value' => 'كلمة المرور','class' => 'text-sm font-semibold text-gray-700']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald8ba2b4c22a13c55321e34443c386276)): ?>
<?php $attributes = $__attributesOriginald8ba2b4c22a13c55321e34443c386276; ?>
<?php unset($__attributesOriginald8ba2b4c22a13c55321e34443c386276); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald8ba2b4c22a13c55321e34443c386276)): ?>
<?php $component = $__componentOriginald8ba2b4c22a13c55321e34443c386276; ?>
<?php unset($__componentOriginald8ba2b4c22a13c55321e34443c386276); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input','data' => ['id' => 'password','type' => 'password','name' => 'password','required' => true,'class' => 'mt-1 w-full text-right border-gray-300 rounded-xl focus:ring-yellow-500 focus:border-yellow-500','placeholder' => '••••••••']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'password','type' => 'password','name' => 'password','required' => true,'class' => 'mt-1 w-full text-right border-gray-300 rounded-xl focus:ring-yellow-500 focus:border-yellow-500','placeholder' => '••••••••']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $attributes = $__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__attributesOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1)): ?>
<?php $component = $__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1; ?>
<?php unset($__componentOriginalc2fcfa88dc54fee60e0757a7e0572df1); ?>
<?php endif; ?>
                    </div>

                    
                    <div class="flex justify-between items-center text-sm text-gray-600">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="remember" class="rounded text-yellow-500 focus:ring-yellow-500">
                            تذكرني
                        </label>
                        <a href="<?php echo e(route('password.request')); ?>" class="text-yellow-600 hover:underline">نسيت كلمة المرور؟</a>
                    </div>

                    
                    <button type="submit" class="w-full bg-yellow-400 hover:bg-yellow-500 text-black font-bold py-3 rounded-xl shadow-md">
                        تسجيل الدخول
                    </button>
                </form>

                
                <form id="formPhone" method="POST" action="<?php echo e(route('send.code')); ?>" onsubmit="return mergePhone()" class="space-y-5 hidden">
                    <?php echo csrf_field(); ?>

                    <div class="text-right">
                        <?php if (isset($component)) { $__componentOriginald8ba2b4c22a13c55321e34443c386276 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald8ba2b4c22a13c55321e34443c386276 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.label','data' => ['for' => 'phone_input','value' => 'رقم الهاتف','class' => 'text-sm font-semibold text-gray-700']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'phone_input','value' => 'رقم الهاتف','class' => 'text-sm font-semibold text-gray-700']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald8ba2b4c22a13c55321e34443c386276)): ?>
<?php $attributes = $__attributesOriginald8ba2b4c22a13c55321e34443c386276; ?>
<?php unset($__attributesOriginald8ba2b4c22a13c55321e34443c386276); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald8ba2b4c22a13c55321e34443c386276)): ?>
<?php $component = $__componentOriginald8ba2b4c22a13c55321e34443c386276; ?>
<?php unset($__componentOriginald8ba2b4c22a13c55321e34443c386276); ?>
<?php endif; ?>
                        <div class="flex mt-1">
                            <select id="country_code" class="border border-gray-300 rounded-l-xl px-3 bg-gray-50 text-sm">
                                <option value="+963">🇸🇾 سوريا (+963)</option>
                                <option value="+90">🇹🇷 تركيا (+90)</option>
                                <option value="+971">🇦🇪 الإمارات (+971)</option>
                                <option value="+966">🇸🇦 السعودية (+966)</option>
                                <option value="+20">🇪🇬 مصر (+20)</option>
                            </select>
                            <input id="phone_input" type="text" class="w-full border border-l-0 border-gray-300 rounded-r-xl p-3 text-right text-sm focus:ring-yellow-500 focus:border-yellow-500"
                                   placeholder="987654321" required>
                        </div>
                    </div>

                    <input type="hidden" name="phone" id="phone_full">

                    <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 rounded-xl shadow-md flex items-center justify-center gap-2">
                        💬 إرسال كود عبر واتساب
                    </button>
                </form>

                
                <div class="text-center mt-8 text-sm text-gray-600">
                    لا تملك حسابًا؟
                    <a href="<?php echo e(route('register')); ?>" class="text-yellow-600 font-bold hover:underline">أنشئ حسابًا جديدًا</a>
                </div>

            </div>
        </div>
    </div>

    
    <script>
        const tabEmail = document.getElementById('tabEmail');
        const tabPhone = document.getElementById('tabPhone');
        const formEmail = document.getElementById('formEmail');
        const formPhone = document.getElementById('formPhone');

        tabEmail.addEventListener('click', () => {
            formEmail.classList.remove('hidden');
            formPhone.classList.add('hidden');
            tabEmail.classList.add('bg-yellow-400', 'text-black');
            tabPhone.classList.remove('bg-yellow-400', 'text-black');
            tabPhone.classList.add('bg-gray-100', 'text-gray-700');
        });

        tabPhone.addEventListener('click', () => {
            formPhone.classList.remove('hidden');
            formEmail.classList.add('hidden');
            tabPhone.classList.add('bg-yellow-400', 'text-black');
            tabEmail.classList.remove('bg-yellow-400', 'text-black');
            tabEmail.classList.add('bg-gray-100', 'text-gray-700');
        });

        function mergePhone() {
            const code = document.getElementById('country_code').value;
            const phone = document.getElementById('phone_input').value.replace(/\s+/g, '');
            document.getElementById('phone_full').value = code + phone;
            return true;
        }
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $attributes = $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $component = $__componentOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php /**PATH /home/delni_user/delni/resources/views/auth/unified-login.blade.php ENDPATH**/ ?>