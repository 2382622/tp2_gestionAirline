<template>
    <div class="card shadow-sm language-card" :dir="direction" :lang="lang">
        <div class="card-body">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <span class="fw-semibold text-secondary">{{ t('about.languagesLabel') }}</span>
                    <button
                        v-for="option in languages"
                        :key="option.code"
                        type="button"
                        class="flag-pill"
                        :class="{ 'flag-pill-active': option.code === lang }"
                        @click="changeLang(option.code)"
                    >
                        {{ option.flag }} {{ option.label }}
                    </button>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <label class="fw-semibold mb-0" for="langSelect">{{ t('about.selectionLabel') }}</label>
                    <select
                        id="langSelect"
                        :value="lang"
                        class="form-select form-select-sm w-auto"
                        @change="changeLang($event.target.value)"
                    >
                        <option v-for="option in languages" :key="option.code" :value="option.code">
                            {{ option.flag }} {{ option.label }}
                        </option>
                    </select>
                </div>
            </div>

            <h1 class="h4 mb-3">{{ t('about.title') }}</h1>
            <p class="mb-1">
                <strong>{{ t('about.nameLabel') }}</strong> {{ t('about.names') }}
            </p>
            <p class="mb-3">
                <strong>{{ t('about.courseLabel') }}</strong> {{ t('about.course') }}
            </p>

            <h2 class="h5 mt-4">{{ t('about.checkTitle') }}</h2>
            <ol>
                <li v-for="step in t('about.steps')" :key="step">
                    {{ step }}
                </li>
            </ol>

            <h2 class="h5 mt-4">{{ t('about.diagramTitle') }}</h2>
            <div class="diagram-wrapper mt-3">
                <img
                    src="/images/diagramme-bd.svg"
                    :alt="t('about.diagramAlt')"
                    class="img-fluid border rounded"
                />
            </div>
        </div>
    </div>
</template>

<script>
import { useI18n } from '../i18n'

export default {
    name: 'About',
    setup() {
        const { t, lang, direction, languages, setLang } = useI18n()
        return { t, lang, direction, languages, setLang }
    },
    methods: {
        changeLang(code) {
            this.setLang(code)
        },
    },
}
</script>

<style scoped>
.language-card {
    transition: direction 0.2s ease;
}

.flag-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 10px;
    border-radius: 999px;
    border: 1px solid #e2e8f0;
    background: #f8fafc;
    font-size: 0.9rem;
    line-height: 1.1;
    cursor: pointer;
}

.flag-pill-active {
    border-color: #6366f1;
    background: #eef2ff;
    color: #312e81;
    box-shadow: 0 0 0 1px #6366f1 inset;
}
</style>
