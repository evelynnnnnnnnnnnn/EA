import type { ProcessOptions, OptionsField, QueueAction, ProcessResult } from './process-types';
import {ProcessResultStatus, ProcessState} from './process-types';
import {ProcessManager} from './process-manager';
import {Process, ProcessCallback, ProcessEvent} from './process';
import {Dialog, DialogEvent} from './dialog';

import './css/style.css';

export type {
	ProcessOptions,
	OptionsField,
	QueueAction,
	ProcessResult,
}

export {
	ProcessManager,
	Process,
	ProcessState,
	ProcessEvent,
	ProcessCallback,
	ProcessResultStatus,
	Dialog,
	DialogEvent,
}
