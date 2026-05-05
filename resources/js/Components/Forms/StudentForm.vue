<script setup>
import { ref, computed } from 'vue'

const { form, guardians = [], teachers = [] } = defineProps({
  form: { type: Object, required: true },
  guardians: { type: Array, default: () => [] },
  teachers: { type: Array, default: () => [] },
})

function get_full_name(person) {
  return [person.first_name, person.middle_name, person.last_name]
    .filter(Boolean)
    .join(' ')
}

// --- Guardian search ---
const guardian_search = ref('')
const show_guardian_drop = ref(false)

const filtered_guardians = computed(() => {
  const list = (guardians ?? []).filter(g => !form.guardian_ids.includes(g.id))
  if (!guardian_search.value) return list
  return list.filter(g =>
    get_full_name(g).toLowerCase().includes(guardian_search.value.toLowerCase())
  )
})

function select_guardian(guardian) {
  form.guardian_ids.push(guardian.id)
  form.relationships.push('')
  guardian_search.value = ''
  show_guardian_drop.value = false
}

function remove_guardian(index) {
  form.guardian_ids.splice(index, 1)
  form.relationships.splice(index, 1)
}

function hide_guardian_dropdown() {
  setTimeout(() => { show_guardian_drop.value = false }, 150)
}

function get_guardian_name(id) {
  const found = guardians.find(g => g.id === id)
  return found ? get_full_name(found) : ''
}

// --- Teacher search ---
const teacher_search = ref('')
const show_teacher_drop = ref(false)

const filtered_teachers = computed(() => {
  const list = (teachers ?? []).filter(t => !form.teacher_ids.includes(t.id))
  if (!teacher_search.value) return list
  return list.filter(t =>
    get_full_name(t).toLowerCase().includes(teacher_search.value.toLowerCase())
  )
})

function select_teacher(teacher) {
  form.teacher_ids.push(teacher.id)
  teacher_search.value = ''
  show_teacher_drop.value = false
}

function remove_teacher(index) {
  form.teacher_ids.splice(index, 1)
}

function hide_teacher_dropdown() {
  setTimeout(() => { show_teacher_drop.value = false }, 150)
}

function get_teacher_name(id) {
  const found = teachers.find(t => t.id === id)
  return found ? get_full_name(found) : ''
}
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

    <!-- Link guardians -->
    <div class="flex flex-col gap-1.5">
      <label class="text-xs font-medium text-gray-600">
        Link guardians
        <span class="text-gray-300 font-normal ml-1">(optional)</span>
      </label>

      <input v-model="guardian_search" type="text" placeholder="Search guardian name..."
        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-800 placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition"
        @focus="show_guardian_drop = true" @blur="hide_guardian_dropdown" />

      <!-- Dropdown -->
      <div v-if="show_guardian_drop && filtered_guardians.length > 0"
        class="border border-gray-200 rounded-lg overflow-hidden bg-white">
        <button v-for="guardian in filtered_guardians" :key="guardian.id" type="button"
          @mousedown.prevent="select_guardian(guardian)"
          class="w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors border-b border-gray-100 last:border-0">
          {{ get_full_name(guardian) }}
        </button>
      </div>

      <div v-if="show_guardian_drop && guardian_search && filtered_guardians.length === 0"
        class="border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-400">
        No guardian found
      </div>

      <!-- Selected guardians list -->
      <div v-if="form.guardian_ids.length > 0" class="flex flex-col gap-2 mt-1">
        <div v-for="(id, index) in form.guardian_ids" :key="id"
          class="flex items-center gap-2 bg-blue-50 rounded-lg px-3 py-2">
          <span class="text-xs text-blue-600 flex-1 font-medium">
            {{ get_guardian_name(id) }}
          </span>
          <select v-model="form.relationships[index]"
            class="text-xs border border-blue-200 rounded-md px-2 py-1 text-blue-600 bg-white focus:outline-none focus:ring-1 focus:ring-blue-300">
            <option value="" disabled>Relationship...</option>
            <option value="mother">Mother</option>
            <option value="father">Father</option>
            <option value="grandmother">Grandmother</option>
            <option value="grandfather">Grandfather</option>
            <option value="aunt">Aunt</option>
            <option value="uncle">Uncle</option>
            <option value="sibling">Sibling</option>
            <option value="guardian">Legal guardian</option>
          </select>
          <button type="button" @click="remove_guardian(index)"
            class="text-blue-300 hover:text-red-400 transition-colors text-xs">
            Remove
          </button>
        </div>
      </div>
    </div>

    <!-- Link teachers -->
    <div class="flex flex-col gap-1.5">
      <label class="text-xs font-medium text-gray-600">
        Link teachers
        <span class="text-gray-300 font-normal ml-1">(optional)</span>
      </label>

      <input v-model="teacher_search" type="text" placeholder="Search teacher name..."
        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-800 placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition"
        @focus="show_teacher_drop = true" @blur="hide_teacher_dropdown" />

      <!-- Dropdown -->
      <div v-if="show_teacher_drop && filtered_teachers.length > 0"
        class="border border-gray-200 rounded-lg overflow-hidden bg-white">
        <button v-for="teacher in filtered_teachers" :key="teacher.id" type="button"
          @mousedown.prevent="select_teacher(teacher)"
          class="w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors border-b border-gray-100 last:border-0">
          {{ get_full_name(teacher) }}
        </button>
      </div>

      <div v-if="show_teacher_drop && teacher_search && filtered_teachers.length === 0"
        class="border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-400">
        No teacher found
      </div>

      <!-- Selected teachers list -->
      <div v-if="form.teacher_ids.length > 0" class="flex flex-col gap-2 mt-1">
        <div v-for="(id, index) in form.teacher_ids" :key="id"
          class="flex items-center gap-2 bg-teal-50 rounded-lg px-3 py-2">
          <span class="text-xs text-teal-600 flex-1 font-medium">
            {{ get_teacher_name(id) }}
          </span>
          <button type="button" @click="remove_teacher(index)"
            class="text-teal-300 hover:text-red-400 transition-colors text-xs">
            Remove
          </button>
        </div>
      </div>
    </div>

  </div>
</template>