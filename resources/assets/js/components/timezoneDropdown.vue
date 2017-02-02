<template>
    <select :class="class" v-model="timezone" name="timezone" data-live-search="true">
        <optgroup v-for="(region, list) in timezoneList" :label="region">
            <option v-for="(currentTimezone, name) in list" :value="currentTimezone">
                {{ name }}
            </option>
        </optgroup>
    </select>
</template>

<script>

export default {
    props: ['class', 'timezone', 'timezoneList'],
}
</script>
