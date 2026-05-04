<script setup>
import SlideModal from '@/Components/SlideModal.vue'
import { ref, computed } from 'vue'

const active_tab = ref('students')

const tabs = [
  { key: 'students', label: 'Students' },
  { key: 'teachers', label: 'Teachers' },
  { key: 'guardians', label: 'Guardians' },
]

const students = [
  { id: 1, first_name: 'Juan', middle_name: 'Santos', last_name: 'Dela Cruz', contact_number: '+63 912 345 6789' },
  { id: 2, first_name: 'Ana', middle_name: null, last_name: 'Lim', contact_number: '+63 917 654 3210' },
  { id: 3, first_name: 'Marco', middle_name: 'Jose', last_name: 'Reyes', contact_number: null },
]

const teachers = [
  { id: 1, first_name: 'Rodel', middle_name: null, last_name: 'Santos', contact_number: '+63 918 111 2222' },
  { id: 2, first_name: 'Liza', middle_name: 'Cruz', last_name: 'Reyes', contact_number: '+63 920 333 4444' },
]

const guardians = [
  { id: 1, first_name: 'Maria', middle_name: 'Santos', last_name: 'Dela Cruz', contact_number: '+63 915 777 8888' },
  { id: 2, first_name: 'Pedro', middle_name: null, last_name: 'Lim', contact_number: '+63 916 999 0000' },
]

const data = computed(() => {
  if (active_tab.value === 'students') return students
  if (active_tab.value === 'teachers') return teachers
  if (active_tab.value === 'guardians') return guardians
  return []
})

function get_initials(first, middle, last) {
  const f = first?.[0] || ""
  const m = middle?.[0] || ""
  const l = last?.[0] || ""

  return (f + m + l).toUpperCase()
}

function get_full_name(person) {
  return [person.first_name, person.middle_name, person.last_name]
    .filter(Boolean)
    .join(' ')
}

const show_slide_modal = ref(false)

const slide_over_title = computed(() => {
  const labels = {
    students: 'Add new student',
    teachers: 'Add new teacher',
    guardians: 'Add new guardian',
  }
  return labels[active_tab.value]
})

</script>

<template>
  <div class="min-h-screen bg-gray-100 p-8">
    <div class="max-w-5xl mx-auto">
      <div class="mb-6">
        <h1 class="text-xl font-medium text-gray-900" School Records></h1>
        <p class="text-sm text-gray-500 mt-1">Manage students, teachers, and guardians</p>
      </div>

      <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
          <div>
            <p class="text-sm font-medium text-gray-800 capitalize">{{ active_tab }}</p>
            <p class="text-xs text-gray-400 mt-0.5">{{ data.length }} {{ active_tab }} found</p>
          </div>
          <button @click="show_slide_modal = true"
            class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors">
            <span class="text-lg leading-none">+</span>
            Add {{ active_tab.slice(0, -1) }}
          </button>
        </div>

        <div class="flex border-b border-gray-100 px-6">
          <button v-for="tab in tabs" :key="tab.key" @click="active_tab = tab.key"
            class="py-3 px-4 text-sm border-b2 transition-colors" :class="active_tab === tab.key
              ? 'border-blue-600 text-blue-600 font-medium'
              : 'border=transparent text-gray-400 hover:text-gray-600'">
            {{ tab.label }}
          </button>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-sm">

            <thead>
              <tr class="bg-gray-50 border-b border-gray-100">
                <th class="text-left text-xs text-gray-400 font-medium uppercase tracking-wide px-6 py-3">
                  Name
                </th>
                <th class="text-left text-xs text-gray-400 font-medium uppercase tracking-wide px-6 py-3">
                  Contact number
                </th>
                <th class="px-6 py-3"></th>
              </tr>
            </thead>

            <tbody>
              <tr v-for="person in data" :key="person.id"
                class="border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
                <td class="px-6 py-3">
                  <div class="flex items-center gap-3">
                    <div
                      class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 text-xs font-medium flex items-center justify-center flex-shrink-0">
                      {{ get_initials(person.first_name, person.middle_name, person.last_name) }}
                    </div>
                    <span class="text-gray-800">{{ get_full_name(person) }}</span>
                  </div>
                </td>

                <td class="px-6 py-3 text-gray-400">
                  {{ person.contact_number ?? 'not set' }}
                </td>

                <td class="px-6 py-3">
                  <div class="flex items-center justify-end gap-2">
                    <button
                      class="text-xs text-gray-400 hover:text-blue-600 border border-gray-200 hover:border-blue-200 rounded-md px-3 py-1.5 transition-colors">
                      Edit
                    </button>
                    <button
                      class="text-xs text-red-400 hover:text-red-600 border border-red-100 hover:border-red-300 rounded-md px-3 py-1.5 transition-colors">
                      Delete
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

      </div>
    </div>
    <SlideModal :show="show_slide_modal" :title="slide_over_title" @close="show_slide_modal = false">
      <p class="text-sm text-gray-400">Form goes here in step 4.</p>

      <template #footer>
        <div class="flex gap-3">
          <button @click="show_slide_modal = false"
            class="flex-1 border border-gray-200 text-gray-500 text-sm rounded-lg py-2 hover:bg-gray-50 transition-colors">
            Cancel
          </button>
          <button
            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg py-2 transition-colors">
            Save
          </button>
        </div>
      </template>
    </SlideModal>
  </div>
</template>