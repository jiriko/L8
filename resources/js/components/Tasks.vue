<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Tasks</div>

                <div class="card-body">
                    <form action="" @submit.prevent="createTask">
                        <div class="row">
                            <div class="col-md-6 d-flex justify-content-between">
                                <input v-model="newTask.title" required type="text" class="form-control">
                                <button :disabled="submitting" type="submit" class="ml-2 btn btn-primary"> Add</button>
                            </div>
                        </div>
                    </form>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <ul>
                                <li v-for="task in tasks" :key="task.id"
                                    class="task d-flex justify-content-between mb-2 align-items-baseline">
                                    <p :class="{'completed': task.completed_at}">{{ task.title }}</p>
                                    <button class="btn btn-sm btn-primary ml-2" v-show="! task.completed_at"
                                            @click.prevent="complete(task)">Complete
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <apexchart ref="burndown" width="750" type="line" :options="options"
                                       :series="series"></apexchart>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: "Tasks",
    data() {
        return {
            submitting: false,
            newTask: {
                title: ''
            },
            tasks: [],
            options: {
                chart: {
                    id: 'burndown-chart'
                },
                xaxis: {
                    categories: _.range(1, 60)
                },
                yaxis: {
                    show: true,
                    showAlways: true,
                    min: 0,
                    max: 15,
                },
                stroke: {
                    width: 1.5,
                    curve: 'stepline'
                }
            },
            series: [{
                name: 'tasks',
                data: []
            }]
        }
    },
    created() {
        this.fetch()
        this.burndown()
    },
    methods: {
        async fetch() {
            let response = await axios.get('/api/tasks')
            this.tasks = response.data.data
        },
        async createTask() {
            this.submitting = true
            let response = await axios.post('/api/tasks', this.newTask)
            this.tasks.unshift(response.data.data)
            this.newTask.title = ''
            this.submitting = false
            this.burndown()
        },
        async complete(task) {
            task.completed_at = true
            await axios.post(`/api/tasks/${task.id}/complete`, this.newTask)
            this.burndown()
        },
        async burndown() {
            let response = await axios.get('/api/tasks/burndown')
            this.series[0].data = response.data
            this.$refs.burndown.updateSeries(this.series);
        }
    }
}
</script>

<style scoped>
.completed {
    text-decoration: line-through;
}

.task {
    border-bottom: 1px solid #c7eed8;
}
</style>
