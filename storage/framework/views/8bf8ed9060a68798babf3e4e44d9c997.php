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
    <div class="max-w-md mx-auto bg-white p-8 rounded-2xl shadow-md mt-10">
        <div class="text-center mb-6">
            <img src="/logo.png" class="w-20 mx-auto mb-3">
            <h2 class="text-2xl font-bold">تسجيل الدخول / إنشاء حساب</h2>
            <p class="text-gray-600 text-sm">أدخل رقم هاتفك للمتابعة</p>
        </div>

        
        <?php if(session('success')): ?>
            <div class="bg-green-100 text-green-700 p-2 rounded mb-2 text-sm"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        
        <?php if($errors->any()): ?>
            <div class="bg-red-100 text-red-700 p-2 rounded mb-2 text-sm"><?php echo e($errors->first()); ?></div>
        <?php endif; ?>

        <form action="<?php echo e(route('send.code')); ?>" method="POST" class="space-y-4" onsubmit="return mergePhone()">
            <?php echo csrf_field(); ?>

            <label class="text-sm text-gray-700 block text-right">رقم الهاتف</label>

            <div class="flex">
                
                <select id="country_code" class="border border-gray-300 rounded-l-lg px-3 bg-gray-50 text-sm">
                    <option value="+963">🇸🇾 سوريا (+963)</option>
                    <option value="+90">🇹🇷 تركيا (+90)</option>
                    <option value="+971">🇦🇪 الإمارات (+971)</option>
                    <option value="+966">🇸🇦 السعودية (+966)</option>
                    <option value="+20">🇪🇬 مصر (+20)</option>
                </select>

                
                <input type="text" id="phone_input" class="w-full border rounded-r-lg p-3 text-sm"
                       placeholder="مثال: 987654321" required>
            </div>

            
            <input type="hidden" name="phone" id="phone_full">

            <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg text-lg hover:bg-green-700">
                إرسال كود عبر واتساب ✅
            </button>
        </form>
    </div>

    <script>
        function mergePhone() {
            let code = document.getElementById('country_code').value;
            let phone = document.getElementById('phone_input').value.replace(/\s+/g, '');
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
<?php /**PATH /home/delni_user/delni/resources/views/auth/login_phone.blade.php ENDPATH**/ ?>