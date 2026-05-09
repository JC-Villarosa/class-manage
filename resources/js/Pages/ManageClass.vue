<template>
  <div class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-100">
    <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-40">
      <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <div>
          <h1 class="text-2xl font-bold text-gray-900">Class Manager</h1>
          <p class="text-sm text-gray-500 mt-1">Manage students, teachers, and attendance</p>
        </div>
        <div class="flex gap-6 text-sm">
          <div class="text-center">
            <p class="text-2xl font-bold text-indigo-600">{{ students.length }}</p>
            <p class="text-gray-500 text-xs uppercase tracking-wide">Students</p>
          </div>
          <div class="w-px bg-gray-200"></div>
          <div class="text-center">
            <p class="text-2xl font-bold text-indigo-600">{{ teachers.length }}</p>
            <p class="text-gray-500 text-xs uppercase tracking-wide">Teachers</p>
          </div>
          <div class="w-px bg-gray-200"></div>
          <div class="text-center">
            <p class="text-2xl font-bold text-indigo-600">{{ guardians.length }}</p>
            <p class="text-gray-500 text-xs uppercase tracking-wide">Guardians</p>
          </div>
        </div>
      </div>
    </header>

    <div class="max-w-7xl mx-auto px-6 py-8">
      <div class="flex gap-2 mb-8 border-b border-gray-200">
        <button
          v-for="tab in tabs"
          :key="tab.key"
          @click="active_tab = tab.key"
          class="px-5 py-3 text-sm font-medium border-b-2 transition-all duration-200 relative"
          :class="active_tab === tab.key
            ? 'text-indigo-600 border-indigo-600'
            : 'text-gray-500 border-transparent hover:text-gray-700 hover:border-gray-300'"
        >
          <span class="flex items-center gap-2">
            <span>{{ tab.icon }}</span>
            {{ tab.label }}
          </span>
        </button>
      </div>

      <div class="fade-in">
        <div v-if="active_tab === 'students'" class="space-y-6">
          <div class="flex items-center justify-between">
            <div>
              <h2 class="text-xl font-bold text-gray-900">Students</h2>
              <p class="text-sm text-gray-500 mt-1">{{ students.length }} total students</p>
            </div>
            <button @click="open_add_modal('student')" class="btn-primary-lg">
              <span>➕</span> Add Student
            </button>
          </div>

          <div class="card-container">
            <table class="w-full">
              <thead class="table-head">
                <tr>
                  <th class="th">ID</th>
                  <th class="th">Name</th>
                  <th class="th">Contact</th>
                  <th class="th">Guardians</th>
                  <th class="th">Teachers</th>
                  <th class="th text-right">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-if="students.length === 0" class="tr-empty">
                  <td colspan="6" class="py-12">
                    <div class="text-center">
                      <p class="text-gray-400 text-sm">No students yet. Start by adding one.</p>
                    </div>
                  </td>
                </tr>
                <tr v-for="s in students" :key="s.id" class="tr">
                  <td class="td">
                    <span class="badge-id">{{ s.custom_id }}</span>
                  </td>
                  <td class="td">
                    <div>
                      <p class="font-semibold text-gray-900">{{ s.full_name }}</p>
                    </div>
                  </td>
                  <td class="td">
                    <p class="text-gray-600 text-sm">{{ s.contact_number || '—' }}</p>
                  </td>
                  <td class="td">
                    <CountBadge
                      :count="s.guardians?.length"
                      label="guardian"
                      type="info"
                      @click="open_list_modal('Guardians', s.guardians, guardian_columns)"
                    />
                  </td>
                  <td class="td">
                    <CountBadge
                      :count="s.teachers?.length"
                      label="teacher"
                      type="info"
                      @click="open_list_modal('Teachers', s.teachers, teacher_columns)"
                    />
                  </td>
                  <td class="td">
                    <div class="flex gap-2">
                      <button @click="open_edit_modal('student', s)" class="action-btn edit">✏️ Edit</button>
                      <button @click="confirm_delete('student', s)" class="action-btn delete">🗑️ Delete</button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div v-if="active_tab === 'teachers'" class="space-y-6">
          <div class="flex items-center justify-between">
            <div>
              <h2 class="text-xl font-bold text-gray-900">Teachers</h2>
              <p class="text-sm text-gray-500 mt-1">{{ teachers.length }} total teachers</p>
            </div>
            <button @click="open_add_modal('teacher')" class="btn-primary-lg">
              <span>➕</span> Add Teacher
            </button>
          </div>

          <div class="card-container">
            <table class="w-full">
              <thead class="table-head">
                <tr>
                  <th class="th">Name</th>
                  <th class="th">Contact</th>
                  <th class="th">Students Assigned</th>
                  <th class="th text-right">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-if="teachers.length === 0" class="tr-empty">
                  <td colspan="4" class="py-12">
                    <div class="text-center">
                      <p class="text-gray-400 text-sm">No teachers yet. Start by adding one.</p>
                    </div>
                  </td>
                </tr>
                <tr v-for="t in teachers" :key="t.id" class="tr">
                  <td class="td">
                    <p class="font-semibold text-gray-900">{{ t.full_name }}</p>
                  </td>
                  <td class="td">
                    <p class="text-gray-600 text-sm">{{ t.contact_number }}</p>
                  </td>
                  <td class="td">
                    <CountBadge
                      :count="t.students?.length"
                      label="student"
                      type="info"
                      @click="open_list_modal('Students', t.students, student_columns)"
                    />
                  </td>
                  <td class="td">
                    <div class="flex gap-2">
                      <button @click="open_edit_modal('teacher', t)" class="action-btn edit">✏️ Edit</button>
                      <button @click="confirm_delete('teacher', t)" class="action-btn delete">🗑️ Delete</button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div v-if="active_tab === 'guardians'" class="space-y-6">
          <div class="flex items-center justify-between">
            <div>
              <h2 class="text-xl font-bold text-gray-900">Guardians</h2>
              <p class="text-sm text-gray-500 mt-1">{{ guardians.length }} total guardians</p>
            </div>
            <button @click="open_add_modal('guardian')" class="btn-primary-lg">
              <span>➕</span> Add Guardian
            </button>
          </div>

          <div class="card-container">
            <table class="w-full">
              <thead class="table-head">
                <tr>
                  <th class="th">Name</th>
                  <th class="th">Contact</th>
                  <th class="th">Students</th>
                  <th class="th text-right">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-if="guardians.length === 0" class="tr-empty">
                  <td colspan="4" class="py-12">
                    <div class="text-center">
                      <p class="text-gray-400 text-sm">No guardians yet. Start by adding one.</p>
                    </div>
                  </td>
                </tr>
                <tr v-for="g in guardians" :key="g.id" class="tr">
                  <td class="td">
                    <p class="font-semibold text-gray-900">{{ g.full_name }}</p>
                  </td>
                  <td class="td">
                    <p class="text-gray-600 text-sm">{{ g.contact_number }}</p>
                  </td>
                  <td class="td">
                    <CountBadge
                      :count="g.students?.length"
                      label="student"
                      type="info"
                      @click="open_list_modal('Students', g.students, student_columns)"
                    />
                  </td>
                  <td class="td">
                    <div class="flex gap-2">
                      <button @click="open_edit_modal('guardian', g)" class="action-btn edit">✏️ Edit</button>
                      <button @click="confirm_delete('guardian', g)" class="action-btn delete">🗑️ Delete</button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div v-if="active_tab === 'attendance'" class="space-y-6">
          <div>
            <h2 class="text-xl font-bold text-gray-900">Attendance</h2>
            <p class="text-sm text-gray-500 mt-1">Track student check-in and check-out times</p>
          </div>

          <div class="card-container bg-gradient-to-br from-indigo-50 to-white border-l-4 border-indigo-600 p-6">
            <label class="block text-sm font-semibold text-gray-900 mb-3">Student ID</label>
            <div class="flex gap-3">
              <input
                v-model="check_in_id"
                type="text"
                class="input-primary flex-1"
                placeholder="Type student custom ID (e.g., STU-00001)..."
                @keyup.enter="handle_check_in"
              />
              <button @click="handle_check_in" class="btn-success-lg whitespace-nowrap">
                <span>✓</span> Check In
              </button>
              <button @click="handle_check_out" class="btn-warning-lg whitespace-nowrap">
                <span>⊗</span> Check Out
              </button>
            </div>
          </div>

          <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Today's Records</h3>
            <div class="card-container overflow-x-auto">
              <table class="w-full">
                <thead class="table-head">
                  <tr>
                    <th class="th">Student ID</th>
                    <th class="th">Name</th>
                    <th class="th">Time In</th>
                    <th class="th">Time Out</th>
                    <th class="th text-center">Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-if="attendances.length === 0" class="tr-empty">
                    <td colspan="5" class="py-12">
                      <div class="text-center">
                        <p class="text-gray-400 text-sm">No attendance records. Check-in students above.</p>
                      </div>
                    </td>
                  </tr>
                  <tr v-for="(a, i) in attendances" :key="i" class="tr">
                    <td class="td">
                      <span class="badge-id">{{ a.custom_id }}</span>
                    </td>
                    <td class="td">
                      <p class="font-semibold text-gray-900">{{ a.full_name }}</p>
                    </td>
                    <td class="td">
                      <p class="text-gray-700 font-medium">{{ format_time(a.time_in) }}</p>
                    </td>
                    <td class="td">
                      <p class="text-gray-600">{{ a.time_out ? format_time(a.time_out) : '—' }}</p>
                    </td>
                    <td class="td text-center">
                      <span
                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-bold tracking-wide"
                        :class="a.status === 'In'
                          ? 'bg-green-100 text-green-800'
                          : 'bg-gray-100 text-gray-800'"
                      >
                        <span>{{ a.status === 'In' ? '●' : '○' }}</span>
                        {{ a.status }}
                      </span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div v-if="modal.open" class="modal-backdrop" @click.self="close_modal">
      <div class="modal-box">
        <div class="mb-6">
          <h3 class="text-xl font-bold text-gray-900">
            {{ modal.mode === 'add' ? 'Create' : 'Update' }} {{ modal.type | capitalize }}
          </h3>
          <p class="text-sm text-gray-500 mt-1">
            {{ modal.mode === 'add' ? 'Add a new entry' : 'Update this entry' }}
          </p>
        </div>

        <form @submit.prevent="submit_form" class="space-y-4">
          <div class="grid grid-cols-3 gap-3">
            <div>
              <label class="label">First Name *</label>
              <input v-model="form.first_name" type="text" class="input-primary" required />
            </div>
            <div>
              <label class="label">Middle Name</label>
              <input v-model="form.middle_name" type="text" class="input-primary" />
            </div>
            <div>
              <label class="label">Last Name *</label>
              <input v-model="form.last_name" type="text" class="input-primary" required />
            </div>
          </div>

          <div v-if="modal.type === 'teacher'">
            <label class="label">Subject</label>
            <input v-model="form.subject" type="text" class="input-primary" placeholder="e.g., Mathematics" />
          </div>

          <div>
            <label class="label">Contact Number{{ modal.type !== 'student' ? ' *' : '' }}</label>
            <input
              v-model="form.contact_number"
              type="text"
              class="input-primary"
              :required="modal.type !== 'student'"
            />
          </div>

          <div v-if="modal.type === 'guardian'">
            <label class="label">Email</label>
            <input v-model="form.email" type="email" class="input-primary" placeholder="e.g., name@email.com" />
          </div>

          <div v-if="modal.type === 'student'" class="border-t-2 border-gray-200 pt-4 space-y-4">
            <div>
              <label class="label font-semibold text-indigo-600">Assign Teachers</label>
              <div class="grid grid-cols-2 gap-2 max-h-40 overflow-y-auto border border-gray-200 rounded-lg p-3">
                <label v-for="t in teachers" :key="t.id" class="flex items-center gap-2 cursor-pointer hover:bg-gray-50 p-2 rounded">
                  <input
                    type="checkbox"
                    :checked="form.teacher_ids.includes(t.id)"
                    @change="toggle_teacher(t.id)"
                    class="w-4 h-4 text-indigo-600 rounded"
                  />
                  <span class="text-sm text-gray-700">{{ t.full_name }}</span>
                </label>
              </div>
            </div>

            <div>
              <label class="label font-semibold text-indigo-600">Assign Guardians</label>
              <div class="flex flex-col gap-2 max-h-52 overflow-y-auto border border-gray-200 rounded-lg p-3">
                <div v-for="g in guardians" :key="g.id" class="space-y-1">
                  <label class="flex items-center gap-2 cursor-pointer hover:bg-gray-50 p-2 rounded">
                    <input
                      type="checkbox"
                      :checked="g.id in form.guardian_relationships"
                      @change="toggle_guardian(g.id)"
                      class="w-4 h-4 text-indigo-600 rounded"
                    />
                    <span class="text-sm font-medium text-gray-700">{{ g.full_name }}</span>
                  </label>
                  <div v-if="g.id in form.guardian_relationships" class="pl-8">
                    <input
                      v-model="form.guardian_relationships[g.id]"
                      type="text"
                      class="input-primary text-sm"
                      placeholder="Relationship (e.g. Mother, Father, Uncle)"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div v-if="form_error" class="p-3 rounded-lg bg-red-50 border border-red-200">
            <p class="text-sm text-red-700">{{ form_error }}</p>
          </div>

          <div class="flex gap-3 pt-4 border-t border-gray-200">
            <button type="button" @click="close_modal" class="btn-secondary flex-1">Cancel</button>
            <button type="submit" :disabled="submitting" class="btn-primary flex-1">
              {{ submitting ? 'Saving...' : 'Save Changes' }}
            </button>
          </div>
        </form>
      </div>
    </div>

    <div v-if="delete_modal.open" class="modal-backdrop" @click.self="delete_modal.open = false">
      <div class="modal-box max-w-sm">
        <div class="mb-6 text-center">
          <p class="text-4xl mb-4">⚠️</p>
          <h3 class="text-lg font-bold text-gray-900">Delete {{ delete_modal.type }}?</h3>
          <p class="text-sm text-gray-600 mt-2">
            You are about to permanently delete <strong>{{ delete_modal.item?.full_name }}</strong>.
            This action cannot be undone.
          </p>
        </div>
        <div class="flex gap-3">
          <button @click="delete_modal.open = false" class="btn-secondary flex-1">Cancel</button>
          <button @click="execute_delete" :disabled="submitting" class="btn-danger flex-1">
            {{ submitting ? 'Deleting...' : 'Delete' }}
          </button>
        </div>
      </div>
    </div>

    <div v-if="list_modal.open" class="modal-backdrop" @click.self="list_modal.open = false">
      <div class="modal-box">
        <div class="flex items-center justify-between mb-6">
          <h3 class="text-lg font-bold text-gray-900">{{ list_modal.title }}</h3>
          <button @click="list_modal.open = false" class="text-gray-400 hover:text-gray-600 text-2xl leading-none">×</button>
        </div>
        <div class="card-container">
          <div class="overflow-x-auto">
            <table class="min-w-full">
              <thead class="table-head">
                <tr>
                  <th v-for="col in list_modal.columns" :key="col.key" class="th text-left">{{ col.label }}</th>
                </tr>
              </thead>
              <tbody>
                <tr v-if="!list_modal.rows?.length" class="tr-empty">
                  <td :colspan="list_modal.columns.length" class="py-8">
                    <p class="text-center text-gray-400 text-sm">No records found.</p>
                  </td>
                </tr>
                <tr v-for="(row, i) in list_modal.rows" :key="i" class="tr">
                  <td
                    v-for="col in list_modal.columns"
                    :key="col.key"
                    class="td"
                    :class="col.class"
                  >{{ row[col.key] ?? '—' }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <transition name="toast">
      <div v-if="toast.show" :class="['toast', `toast-${toast.type}`]">
        <span>{{ toast.icon }}</span>
        <p>{{ toast.message }}</p>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted, defineComponent, h } from 'vue'
import { router } from '@inertiajs/vue3'

const CountBadge = defineComponent({
  props: { count: Number, label: String, type: String },
  emits: ['click'],
  setup(props, { emit }) {
    const colors = {
      info: 'bg-indigo-50 text-indigo-700 hover:bg-indigo-100',
      success: 'bg-green-50 text-green-700 hover:bg-green-100',
      warning: 'bg-amber-50 text-amber-700 hover:bg-amber-100',
    }
    return () => props.count
      ? h('button', {
          onClick: () => emit('click'),
          class: `inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold tracking-wide transition-colors ${colors[props.type] || colors.info} cursor-pointer`,
        }, `${props.count} ${props.label}${props.count !== 1 ? 's' : ''}`)
      : h('span', { class: 'text-gray-400 text-xs' }, 'None')
  },
})

const student_columns = [
  { key: 'custom_id', label: 'ID', class: 'font-mono text-indigo-700 font-bold' },
  { key: 'full_name', label: 'Name' },
]
const teacher_columns = [
  { key: 'full_name', label: 'Name' },
  { key: 'subject', label: 'Subject' },
]
const guardian_columns = [
  { key: 'full_name',    label: 'Name' },
  { key: 'contact_number', label: 'Contact' },
  { key: 'email', label: 'Email' },
  { key: 'relationship', label: 'Relationship' },
]

const active_tab = ref('students')
const tabs = [
  { key: 'students',   label: 'Students',   icon: '👥' },
  { key: 'teachers',   label: 'Teachers',   icon: '🎓' },
  { key: 'guardians',  label: 'Guardians',  icon: '👨‍👩‍👧' },
  { key: 'attendance', label: 'Attendance', icon: '📋' },
]

const students  = ref([])
const teachers  = ref([])
const guardians = ref([])
const attendances = ref([])

const submitting = ref(false)
const form_error = ref('')

const modal = reactive({ open: false, mode: 'add', type: '' })
const form  = reactive({
  first_name: '',
  middle_name: '',
  last_name: '',
  subject: '',
  contact_number: '',
  email: '',
  teacher_ids: [],
  guardian_relationships: {},
})
let editing_id = null

const delete_modal = reactive({ open: false, type: '', item: null })
const list_modal = reactive({ open: false, title: '', columns: [], rows: [] })
const toast = reactive({ show: false, message: '', type: 'success', icon: '✓' })

const check_in_id = ref('')

async function fetch_all()
{
  const [s, t, g] = await Promise.all([
    fetch('/students').then(r => r.json()),
    fetch('/teachers').then(r => r.json()),
    fetch('/guardians').then(r => r.json()),
  ])
  students.value  = s
  teachers.value  = t
  guardians.value = g
}

onMounted(fetch_all)

function open_add_modal(type)
{
  Object.assign(form, {
    first_name: '',
    middle_name: '',
    last_name: '',
    subject: '',
    contact_number: '',
    email: '',
    teacher_ids: [],
    guardian_relationships: {},
  })
  editing_id       = null
  form_error.value = ''
  Object.assign(modal, { open: true, mode: 'add', type })
}

function open_edit_modal(type, item)
{
  Object.assign(form, {
    first_name:     item.first_name,
    middle_name:    item.middle_name || '',
    last_name:      item.last_name,
    subject:        item.subject || '',
    contact_number: item.contact_number || '',
    email:          item.email || '',
    teacher_ids:             type === 'student' ? (item.teachers?.map(t => t.id) || []) : [],
    guardian_relationships:  type === 'student'
      ? Object.fromEntries((item.guardians || []).map(g => [g.id, g.relationship || '']))
      : {},
  })
  editing_id       = item.id
  form_error.value = ''
  Object.assign(modal, { open: true, mode: 'edit', type })
}

function toggle_teacher(teacher_id)
{
  const idx = form.teacher_ids.indexOf(teacher_id)
  if (idx === -1) {
    form.teacher_ids.push(teacher_id)
  } else {
    form.teacher_ids.splice(idx, 1)
  }
}

function toggle_guardian(guardian_id)
{
  if (guardian_id in form.guardian_relationships) {
    delete form.guardian_relationships[guardian_id]
  } else {
    form.guardian_relationships[guardian_id] = ''
  }
}

function close_modal()
{
  modal.open = false
}

function open_list_modal(title, rows, columns)
{
  Object.assign(list_modal, { open: true, title, columns, rows: rows ?? [] })
}

async function submit_form()
{
  submitting.value = true
  form_error.value = ''

  const endpoint = modal.type === 'student' ? '/students'
                 : modal.type === 'teacher' ? '/teachers'
                 : '/guardians'

  const url    = modal.mode === 'add' ? endpoint : `${endpoint}/${editing_id}`
  const method = modal.mode === 'add' ? 'POST' : 'PUT'

  const payload = { ...form }
  delete payload.teacher_ids
  delete payload.guardian_relationships
  if (modal.type !== 'teacher') {
    delete payload.subject
  }
  if (modal.type !== 'guardian') {
    delete payload.email
  }

  try {
    const res = await fetch(url, {
      method,
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': get_csrf_token() },
      body: JSON.stringify(payload),
    })

    if (!res.ok) {
      const err = await res.json()
      form_error.value = flatten_errors(err)
      return
    }

    const saved = await res.json()

    if (modal.type === 'student') {
      const student_id = modal.mode === 'add' ? saved.id : editing_id

      await Promise.all([
        form.teacher_ids.length > 0 && fetch(`/students/${student_id}/sync-teachers`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': get_csrf_token() },
          body: JSON.stringify({ teacher_ids: form.teacher_ids }),
        }),
        Object.keys(form.guardian_relationships).length > 0 && fetch(`/students/${student_id}/sync-guardians`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': get_csrf_token() },
          body: JSON.stringify({
            guardians: Object.entries(form.guardian_relationships).map(([id, relationship]) => ({
              id: parseInt(id),
              relationship: relationship || null,
            })),
          }),
        }),
      ].filter(Boolean))

      await fetch_all()
    } else {
      const list = modal.type === 'teacher' ? teachers : guardians

      if (modal.mode === 'add') {
        list.value.unshift(saved)
      } else {
        const idx = list.value.findIndex(r => r.id === editing_id)
        if (idx !== -1) Object.assign(list.value[idx], saved)
      }
    }

    close_modal()
    show_toast(modal.mode === 'add' ? 'Successfully created!' : 'Successfully updated!', 'success', '✓')
  } catch {
    form_error.value = 'Something went wrong. Please try again.'
  } finally {
    submitting.value = false
  }
}

function confirm_delete(type, item)
{
  Object.assign(delete_modal, { open: true, type, item })
}

async function execute_delete()
{
  submitting.value = true

  const endpoint = delete_modal.type === 'student' ? '/students'
                 : delete_modal.type === 'teacher' ? '/teachers'
                 : '/guardians'

  try {
    const res = await fetch(`${endpoint}/${delete_modal.item.id}`, {
      method: 'DELETE',
      headers: { 'X-CSRF-TOKEN': get_csrf_token() },
    })

    if (!res.ok) throw new Error()

    const list = delete_modal.type === 'student' ? students
               : delete_modal.type === 'teacher' ? teachers
               : guardians

    list.value       = list.value.filter(r => r.id !== delete_modal.item.id)
    delete_modal.open = false
    show_toast('Deleted successfully.', 'success', '✓')
  } catch {
    show_toast('Delete failed. Please try again.', 'error', '✕')
  } finally {
    submitting.value = false
  }
}

function find_student_by_custom_id(custom_id)
{
  return students.value.find(s => s.custom_id === custom_id.trim().toUpperCase())
}

function handle_check_in()
{
  router.get(`/attendance/${check_in_id.value}`);

  const student = find_student_by_custom_id(check_in_id.value)

  if (!student) {
    show_toast('Student not found.', 'error', '✕')
    return
  }

  const already_checked_in = attendances.value.find(
    a => a.id === student.id && a.status === 'In'
  )

  if (already_checked_in) {
    show_toast(`${student.full_name} is already checked in.`, 'warning', '⚠')
    return
  }

  attendances.value.push({
    id: student.id,
    custom_id: student.custom_id,
    full_name: student.full_name,
    time_in: new Date(),
    time_out: null,
    status: 'In',
  })

  check_in_id.value = ''
  show_toast(`${student.full_name} checked in.`, 'success', '✓')
}

function handle_check_out()
{
  const student = find_student_by_custom_id(check_in_id.value)

  if (!student) {
    show_toast('Student not found.', 'error', '✕')
    return
  }

  const record = attendances.value.find(
    a => a.id === student.id && a.status === 'In'
  )

  if (!record) {
    show_toast(`${student.full_name} has not checked in yet.`, 'warning', '⚠')
    return
  }

  record.time_out = new Date()
  record.status = 'Out'

  check_in_id.value = ''
  show_toast(`${student.full_name} checked out.`, 'success', '✓')
}

function format_time(date)
{
  if (!date) return '—'
  const d = new Date(date)
  const hours = String(d.getHours()).padStart(2, '0')
  const mins = String(d.getMinutes()).padStart(2, '0')
  return `${hours}:${mins}`
}

function get_csrf_token()
{
  return document.querySelector('meta[name="csrf-token"]')?.content ?? ''
}

function flatten_errors(err)
{
  if (err?.errors) return Object.values(err.errors).flat().join(' ')
  return err?.message || 'Validation failed.'
}

function show_toast(message, type = 'success', icon = '✓')
{
  toast.message = message
  toast.type    = type
  toast.icon    = icon
  toast.show    = true
  setTimeout(() => { toast.show = false }, 3500)
}
</script>

<style scoped>
@reference "tailwindcss";

.badge-id {
  @apply inline-block px-3 py-1 rounded-lg bg-indigo-100 text-indigo-800 text-xs font-bold font-mono tracking-wider;
}

.btn-primary-lg {
  @apply inline-flex items-center gap-2 bg-indigo-600 text-white text-sm font-semibold px-5 py-2.5 rounded-lg hover:bg-indigo-700 active:bg-indigo-800 transition-all duration-200 shadow-sm hover:shadow-md disabled:opacity-50 cursor-pointer;
}

.btn-success-lg {
  @apply inline-flex items-center justify-center gap-2 bg-green-600 text-white text-sm font-semibold px-4 py-2.5 rounded-lg hover:bg-green-700 active:bg-green-800 transition-all duration-200 shadow-sm hover:shadow-md disabled:opacity-50 cursor-pointer;
}

.btn-warning-lg {
  @apply inline-flex items-center justify-center gap-2 bg-amber-600 text-white text-sm font-semibold px-4 py-2.5 rounded-lg hover:bg-amber-700 active:bg-amber-800 transition-all duration-200 shadow-sm hover:shadow-md disabled:opacity-50 cursor-pointer;
}

.btn-primary {
  @apply bg-indigo-600 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-indigo-700 active:bg-indigo-800 transition-all duration-200 disabled:opacity-50 cursor-pointer;
}

.btn-secondary {
  @apply bg-gray-100 text-gray-700 text-sm font-semibold px-4 py-2 rounded-lg hover:bg-gray-200 active:bg-gray-300 transition-all duration-200 cursor-pointer border border-gray-200;
}

.btn-danger {
  @apply bg-red-600 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-red-700 active:bg-red-800 transition-all duration-200 disabled:opacity-50 cursor-pointer;
}

.action-btn {
  @apply inline-flex items-center gap-1 px-3 py-1.5 rounded-md text-xs font-semibold transition-all duration-200 cursor-pointer;
}

.action-btn.edit {
  @apply bg-indigo-50 text-indigo-700 hover:bg-indigo-100 active:bg-indigo-200;
}

.action-btn.delete {
  @apply bg-red-50 text-red-700 hover:bg-red-100 active:bg-red-200;
}

.table-head {
  @apply bg-gray-50 border-b-2 border-gray-200;
}

.th {
  @apply px-4 py-3 text-xs font-bold text-gray-600 uppercase tracking-widest text-left;
}

.td {
  @apply px-4 py-3.5 text-sm text-gray-700;
}

.tr {
  @apply border-b border-gray-100 hover:bg-gray-50 transition-all duration-150;
}

.tr-empty {
  @apply hover:bg-white;
}

.card-container {
  @apply bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm transition-all duration-200 hover:shadow-md;
}

.label {
  @apply block text-sm font-semibold text-gray-700 mb-2;
}

.input-primary {
  @apply w-full border-2 border-gray-200 rounded-lg px-3.5 py-2.5 text-sm font-medium focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 transition-all duration-200 placeholder:text-gray-400;
}

.modal-backdrop {
  @apply fixed inset-0 bg-black/30 backdrop-blur-sm flex items-center justify-center z-50 p-4;
  animation: fade-in 0.3s ease-in-out;
}

.modal-box {
  @apply bg-white rounded-2xl shadow-2xl w-full max-w-lg p-6;
  animation: slide-up 0.3s ease-out;
}

.toast {
  @apply fixed bottom-6 right-6 flex items-center gap-3 text-white text-sm font-semibold px-5 py-3.5 rounded-lg shadow-lg z-50;
  animation: slide-up 0.3s ease-out;
}

.toast-success {
  @apply bg-green-600 border border-green-700;
}

.toast-error {
  @apply bg-red-600 border border-red-700;
}

.toast-warning {
  @apply bg-amber-600 border border-amber-700;
}

.fade-in {
  animation: fade-in 0.3s ease-in-out;
}

.slide-up {
  animation: slide-up 0.3s ease-out;
}

@keyframes fade-in {
  from { opacity: 0; }
  to { opacity: 1; }
}

@keyframes slide-up {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.toast-enter-active, .toast-leave-active {
  transition: all 0.3s ease;
}

.toast-enter-from, .toast-leave-to {
  opacity: 0;
  transform: translateY(20px);
}
</style>
