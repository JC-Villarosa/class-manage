<script setup>
defineProps({
  form: { type: Object, required: true }
})
</script>

<template>
    <div class="flex flex-col gap-5">

        <div class="flex flex-col gap-1.5">
            <label class="text-xs font-medium text-gray-600">
                First name <span class="text-red-400">*</span>
            </label>
            <input v-model="form.first_name" type="text" placeholder="e.g. Juan"
                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-800 placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition" />
        </div>

        <div class="flex flex-col gap-1.5">
            <label class="text-xs font-medium text-gray-600">
                Middle name
                <span class="text-gray-300 font-normal ml-1">(optional)</span>
            </label>
            <input v-model="form.middle_name" type="text" placeholder="e.g. Santos"
                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-800 placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition" />
        </div>

        <div class="flex flex-col gap-1.5">
            <label class="text-xs font-medium text-gray-600">
                Last name <span class="text-red-400">*</span>
            </label>
            <input v-model="form.last_name" type="text" placeholder="e.g. Dela Cruz"
                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-800 placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition" />
        </div>

        <div class="flex flex-col gap-1.5">
            <label class="text-xs font-medium text-gray-600">
                Contact number
                <span class="text-gray-300 font-normal ml-1">(optional)</span>
            </label>
            <input v-model="form.contact_number" type="text" placeholder="+63 9XX XXX XXXX"
                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-800 placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition" />
        </div>

    </div>
</template>