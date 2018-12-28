<template>
    <v-list dense>
        <v-list-tile href="/dashboard">
            <v-list-tile-action>
                <v-icon>dashboard</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
                <v-list-tile-title>Dashboard</v-list-tile-title>
            </v-list-tile-content>
        </v-list-tile>
        <v-list-tile href="/customer">
            <v-list-tile-action>
                <v-icon>contact_mail</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
                <v-list-tile-title>Customers</v-list-tile-title>
            </v-list-tile-content>
        </v-list-tile>
        <v-list-tile href="/projectcase">
            <v-list-tile-action>
                <v-icon>schedule</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
                <v-list-tile-title>Project Cases</v-list-tile-title>
            </v-list-tile-content>
        </v-list-tile>
    </v-list>
</template>
