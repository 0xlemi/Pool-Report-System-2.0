<template>

  <checkbox-list  :data="permission_reports"></checkbox-list>

</template>

<script>
  export default {
    props: ['person', 'url'],
    data () {
      return {
        permission_reports: [
          {id: "get_reports_emails", name: "Send email when new report is created", checked: this.person['get_reports_emails'] },
        ],
      }
    }
  }
</script>

<style scoped>
  h1 {
    color: red;
  }
</style>
