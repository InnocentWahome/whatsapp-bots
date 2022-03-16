import inspect


def get_screens():
    from .screens import screens
    from .base_screens import Screen
    screen_urls = []
    for key, value in screens.items():
        if inspect.isclass(value):
            if issubclass(value, Screen) and not value == Screen:
                screen_urls.append(value)
    return screen_urls
