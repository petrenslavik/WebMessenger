module.exports = {
    chainWebpack: config => {
        config.plugin("html")
            .tap(args => {
                    args[0].template = "src/frontend/public/index.html";
                    return args;
            });
        config.entryPoints.delete('app');

        config.entry('app')
            .add('./src/frontend/Scripts/app.js')
            .end();
        config.resolve.alias
            .set("Vue","node_modules/vue")
            .set("VueRouter","node_modules/vue-router")
    }
}