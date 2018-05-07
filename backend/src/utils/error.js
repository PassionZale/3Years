import { Message } from 'iview'

export const superUserIsNotExist = (msg) => {
    Message.error({
        render: h => {
            return h(
                'span',
                [
                    msg,
                    h('a', {
                        attrs: {
                            href: '#/superuser'
                        }
                    }, '前往创建')
                ]
            )
        }
    });
}

export const superUserIsExist = (msg) => {
    Message.error({
        render: h => {
            return h(
                'span',
                [
                    msg,
                    h('a', {
                        attrs: {
                            href: '#/login'
                        }
                    }, '前往登录')
                ]
            )
        }
    });
}

export const defaultErrorMsg = (msg) => {
    Message.error({
        render: h => {
            return h(
                'span',
                [msg]
            )
        }
    });
}