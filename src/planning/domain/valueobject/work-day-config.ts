import { WorkDayStatus } from '@/planning/domain/enum/work-day-status'

interface TimePeriod {
  start: string
  end: string
}

export interface WorkDayConfig {
  status: WorkDayStatus
  periods: TimePeriod[]
}
